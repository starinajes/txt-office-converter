<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Common\Formatter\FormatInterface;

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
            // 'csv'  => new CsvFormat(),
            default => throw new Exception("Неизвестный формат: $format"),
        };
    }
} 