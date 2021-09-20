<?php


namespace App\Helpers;

class ConverterHelper
{
    public static function parseObj2Arr($obj, $isUTF = 0, $arr = [])
    {
        $isUTF = $isUTF ? 1 : 0;
        if (is_object($obj) || is_array($obj)) {
            $arr = array();
            foreach ($obj as $key => $value) {
                if ($key === "GLOBALS") continue;
                $arr[$key] = self::parseObj2Arr($value, $isUTF, $arr);
            }
            return $arr;
        } elseif (gettype($obj) == 'boolean') {
            return $obj ? 'true' : 'false';
        } else {
            // конверт строк: utf-8 --> windows-1251
            if ($isUTF && gettype($obj) == 'string')
                $obj = iconv('utf-8', 'windows-1251', $obj);
            return $obj;
        }
    }
}
