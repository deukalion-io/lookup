<?php


namespace Lookup;


class Util
{

    public static function wrap_in_char($str, $char): string
    {
        return $char . $str . strrev($char);
    }

}