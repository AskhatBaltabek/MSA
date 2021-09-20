<?php


namespace App\Helpers;


use Faker\Provider\Text;
use Illuminate\Support\Facades\Blade;

class TextHelper
{
    public static function bladeCompile($value, array $args = [])
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        try {
            eval('?>' . $generated);
        } catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    /**
     * @param int $value
     * @param string $lang
     * @return string
     */
    public static function numberToString(int $value, $lang = 'ru')
    {
        if ($lang == 'kz') {
            $nul     = 'нөл';
            $ten     = [
                ['', 'бір', 'екі', 'үш', 'төрт', 'бес', 'алты', 'жеті', 'сегіз', 'тоғыз'],
                ['', 'бір', 'екі', 'үш', 'төрт', 'бес', 'алты', 'жеті', 'сегіз', 'тоғыз'],
            ];
            $a20     = ['он', 'он бір', 'он екі', 'он үш', 'он төрт', 'он бес', 'он алты', 'он жеті', 'он сегіз', 'он тоғыз'];
            $tens    = [2 => 'жиырма', 'отыз', 'қырық', 'елу', 'алпыс', 'жетпіс', 'сексен', 'тоқсан'];
            $hundred = ['', 'жүз', 'екі жүз', 'үш жүз', 'төрт жүз', 'бес жүз', 'алты жүз', 'жеті жүз', 'сегіз жүз', 'тоғыз жүз'];
            $unit    = [ // Units
                         ['', '', '', 1],
                         ['', '', '', 0],
                         ['мың', 'мың', 'мың', 1],
                         ['миллион', 'миллион', 'миллион', 0],
                         ['миллиард', 'миллиард', 'миллиард', 0]
            ];
        } else {
            $nul     = 'ноль';
            $ten     = [
                ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
                ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ];
            $a20     = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
            $tens    = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
            $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
            $unit    = [ // Units
                         ['', '', '', 1],
                         ['', '', '', 0],
                         ['тысяча', 'тысячи', 'тысяч', 1],
                         ['миллион', 'миллиона', 'миллионов', 0],
                         ['миллиард', 'милиарда', 'миллиардов', 0]
            ];
        }

        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($value)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk     = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1];            # 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = TextHelper::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        $out[] = TextHelper::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = ' ' . TextHelper::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]);   // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @param $n
     * @param $f1
     * @param $f2
     * @param $f5
     * @return mixed
     */
    public static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }

    /**
     * Обработка ошибки ЕСБД
     * @param $errorText
     * @return string
     */
    public static function parseEsbdError($errorText) : string
    {
        if(strpos($errorText, 'ORA')){
            preg_match('/(ORA-\d*:\s)+(.*)/', $errorText, $matches);
            $errors_count = count($matches);
            return $errors_count > 0 ? $matches[$errors_count - 1] : $errorText;
        }elseif (strpos($errorText, 'ORA')){
            preg_match('/EMSG:+(.*)/', $errorText, $matches);
            $errors_count = count($matches);
            return $errors_count > 0 ? $matches[$errors_count - 1] : $errorText;
        }else{
            return $errorText;
        }
    }

    /**
     * Creating ObjectIDs.
     * Using current timestamp, hostname, processId and a incremting id.
     *
     * @author Julius Beckmann
     * @throws Exception
     */
    public static function createObjectId()
    {
        $timestamp = time();
        $hostname = php_uname('n');
        $processId = getmypid();
        $id = rand(1,10);
        // Building binary data.
        $bin = sprintf(
            "%s%s%s%s",
            pack('N', $timestamp),
            substr(md5($hostname), 0, 3),
            pack('n', $processId),
            substr(pack('N', $id), 1, 3)
        );
        // Convert binary to hex.
        $result = '';
        for ($i = 0; $i < 12; $i++) {
            $result .= sprintf("%02x", ord($bin[$i]));
        }
        return $result;
    }
}
