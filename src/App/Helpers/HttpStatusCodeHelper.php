<?php

namespace Console\App\Helpers;

class HttpStatusCodeHelper
{
    public static function isRedirect(int $code): bool
    {
        return (300 <= $code) && ($code <= 399);
    }
}