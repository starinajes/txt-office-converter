<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Common\Formatter\FormatInterface;
use App\Infrastructure\Formatter\JsonFormat;
use App\Infrastructure\Formatter\XmlFormat;
// use App\Infrastructure\Formatter\CsvFormat; // Для будущей поддержки CSV-вывода
use Exception;

class FormatterFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $format): FormatInterface
    {
        return match (strtolower($format)) {
            'json' => new JsonFormat(),
            'xml'  => new XmlFormat(),
            // 'csv'  => new CsvFormat(), // Раскомментировать, если потребуется CSV-вывод
            default => throw new Exception("Неизвестный формат: $format"),
        };
    }
} 