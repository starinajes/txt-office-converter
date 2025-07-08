<?php

namespace App\Infrastructure\Parser;

use App\Domain\Common\Parser\ParserInterface;
use Exception;

class ParserFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $filePath, ?string $type = null): ParserInterface
    {
        if ($type) {
            return match ($type) {
                'car' => new CsvCarParser(),
                'office' => new TxtOfficeParser(),
                // другие типы
                default => throw new Exception("Неизвестный тип: $type"),
            };
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Дефолт
        return match ($ext) {
            'txt' => new TxtOfficeParser(),
            'csv' => new CsvCarParser(),
            default => throw new Exception("Неизвестен формат файла: $ext"),
        };
    }
} 