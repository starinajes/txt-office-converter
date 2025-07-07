<?php

namespace OfficeConverter\Command;

use Exception;

class CommandRegistry
{
    private static array $commands = [
        'convert' => ConvertCommand::class,
    ];

    /**
     * @throws Exception
     */
    public static function getCommand(string $name): CommandInterface
    {
        if (!isset(self::$commands[$name])) {
            throw new Exception("Неизвестная команда: $name");
        }
        return new self::$commands[$name]();
    }

    /**
     * @throws Exception
     */
    public static function createConfig(string $name, array $args): object
    {
        if (!isset(self::$commands[$name])) {
            throw new Exception("Неизвестная команда: $name");
        }
        return self::$commands[$name]::fromArgs($args);
    }
} 