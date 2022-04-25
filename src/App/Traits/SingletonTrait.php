<?php

namespace Console\App\Traits;

trait SingletonTrait
{
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function instance(): static
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
