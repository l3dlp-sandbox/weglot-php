<?php

namespace Weglot\Parser\Util;

/**
 * Class Text
 * @package Weglot\Parser\Util
 */
class Text
{
    /**
     * @param string $word
     * @return string
     */
    public static function fullTrim($word)
    {
        return trim($word, " \t\n\r\0\x0B\xA0�");
    }

    /**
     * @param string $haystack
     * @param string $search
     * @return bool
     */
    public static function contains($haystack, $search)
    {
        return strpos($haystack, $search) !== false;
    }
}
