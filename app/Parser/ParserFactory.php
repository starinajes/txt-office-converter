<?php
namespace OfficeConverter\Parser;

use Exception;

class ParserFactory
{
    /**
     * @throws Exception
     */
    public static function createParser(string $filename): ParserInterface
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return match ($ext) {
            'txt' => new TxtParser(),
            // 'xml' => new XmlParser(),
            // 'json' => new JsonParser(),
            default => throw new Exception("Неизвестный формат файла: $ext"),
        };
    }
} 