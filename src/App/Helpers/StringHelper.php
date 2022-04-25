<?php

namespace Console\App\Helpers;

class StringHelper
{
    public static function match(string $pattern, string $subject): array
    {
        $result = [];
        preg_match($pattern, $subject, $result);
        return $result;
    }

    public static function contains(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle);
    }

    public static function hash(string $value): string
    {
        return md5($value);
    }
}
