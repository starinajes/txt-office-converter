<?php

namespace OfficeConverter\Command;

use OfficeConverter\Controller\OfficeConverter;
use Exception;

class CommandFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $commandName): CommandInterface
    {
        $officeConverter = new OfficeConverter();

        return match ($commandName) {
            'to:json' => new JsonConvertCommand($officeConverter),
            'to:xml'  => new XmlConvertCommand($officeConverter),
            default   => throw new Exception("Unknown command: $commandName"),
        };
    }
} 