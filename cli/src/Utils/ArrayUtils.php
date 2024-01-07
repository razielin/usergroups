<?php
namespace App\Utils;

class ArrayUtils
{
    public static function find(array $arr, $callback)
    {
        foreach ($arr as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
        return null;
    }
}
