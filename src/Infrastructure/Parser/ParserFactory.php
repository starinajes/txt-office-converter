<?php

namespace App\Infrastructure\Parser;

use App\Domain\Office\Parser\ParserInterface;
use Exception;

class ParserFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $filePath): ParserInterface
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($ext) {
            'txt' => new TxtParser(),
            // 'csv' => new CsvParser(),
            default => throw new Exception("Неизвестен формат файла: $ext"),
        };
    }
} 