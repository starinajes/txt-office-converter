<?php

namespace App\Infrastructure\Config;

final class Paths
{
    public static function getOutputPath(): string
    {
        return dirname(__DIR__, 3) . '/output/';
    }

    public static function getStoragePath(): string
    {
        return dirname(__DIR__, 3) . '/storage/';
    }
}