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
                if ($key === "GLOBALS" || (is_object($value) && empty((array) $value))) {
                    continue;
                }
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

    public static function convertNullToString($params)
    {
        $first_key = key($params);
        if (is_array($params[$first_key])) {
            foreach ($params[$first_key] as $key => $value) {
                if ($value == null) {
                    $params[$first_key][$key] = "";
                }
                $new_param = $params[$first_key][$key];

                if (is_array($new_param)) {
                    $first_key_new_param = key($new_param);
                    foreach ($new_param[$first_key_new_param] as $new_key => $new_value) {
                        if ($new_value == null) {
                            $params[$first_key][$key][0][$new_key] = "";
                        }
                    }
                }
            }
        }

        foreach ($params as $key => $value) {
            if ($value == null) {
                $params[$key] = "";
            }
        }
        return $params;
    }
}
