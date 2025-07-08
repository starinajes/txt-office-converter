<?php

namespace App\Application\Command;

use Exception;
use App\Domain\Office\Service\OfficeConverterService;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;

class CommandRegistry
{
    private static ?array $commands = null;

    private static function init(): void
    {
        if (self::$commands === null) {
            self::$commands = [
                'convert' => fn() => new ConvertOfficeFileHandler(
                    new OfficeConverterService(),
                    new ParserFactory(),
                    new FormatterFactory()
                ),
            ];
        }
    }

    /**
     * @throws Exception
     */
    public static function getCommand(string $name): CommandInterface
    {
        self::init();
        if (!isset(self::$commands[$name])) {
            throw new Exception("Неизвестная команда: $name");
        }

        return (self::$commands[$name])();
    }

    /**
     * @throws Exception
     */
    public static function createConfig(string $name, array $args): object
    {
        self::init();

        if (!isset(self::$commands[$name])) {
            throw new Exception("Неизвестная команда: $name");
        }

        // fromArgs должен быть у handler'а
        return ConvertOfficeFileHandler::fromArgs($args);
    }
} 