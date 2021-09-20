<?php
namespace App\Helpers;


use Illuminate\Support\Facades\Blade;

class TextHelper
{
    public static function bladeCompile($value, array $args = array())
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        try {
            eval('?>'.$generated);
        } catch (\Exception $e) {
            ob_get_clean(); throw $e;
        }

        return ob_get_clean();
    }
}
