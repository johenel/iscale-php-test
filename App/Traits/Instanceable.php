<?php

namespace App\Traits;

trait Instanceable
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            $class = __CLASS__;

            self::$instance = new $class;
        }
        return self::$instance;
    }
}