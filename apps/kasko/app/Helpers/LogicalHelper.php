<?php


namespace App\Helpers;

class LogicalHelper
{

    /**
     * Используй когда оператор string
     * Функция возращает результат сравнения.
     * @param $a
     * @param $b
     * @param string $operator
     * @return bool
     */
    public static function compare($a, $b, $operator = '==='): bool
    {
        switch ($operator) {
            case '<':
                return $a < $b;
            case '<=':
                return $a <= $b;
            case '>':
                return $a > $b;
            case '>=':
                return $a >= $b;
            case '==':
                return $a == $b;
            case '!=':
                return $a != $b;
            default:
                return $a === $b;
        }
    }

}
