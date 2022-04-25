<?php

namespace Console\App\Helpers;

class ArrayHelper
{
    public static function merge(array $a, array $b): array
    {
        $result = [];
        $keys = array_keys($a + $b);
        foreach ($keys as $key) {
            $result[$key] = ($a[$key] ?? 0) + ($b[$key] ?? 0);
        }
        return $result;
    }

    public static function contains(mixed $needle, array $haystack): bool
    {
        return in_array($needle, $haystack, true);
    }
}