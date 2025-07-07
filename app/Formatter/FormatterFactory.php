<?php

namespace OfficeConverter\Formatter;

use Exception;

class FormatterFactory
{
    public static function create(string $format): FormatInterface
    {
        return match (strtolower($format)) {
            'json' => new JsonFormat(),
            'xml'  => new XmlFormat(),
            default => throw new Exception("Неизвестный формат: $format"),
        };
    }
} 