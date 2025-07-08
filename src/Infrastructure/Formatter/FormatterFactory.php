<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Office\Formatter\FormatInterface;
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
            default => throw new Exception("Неизвестный формат: $format"),
        };
    }
} 