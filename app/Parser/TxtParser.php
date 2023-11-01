<?php

namespace OfficeConverter\Parser;

/**
 * Парсер TXT файлов
 */
class TxtParser implements ParserInterface
{
    public function parse($data): array
    {
        $lines = explode("\n", $data);

        $parsedData = [];
        $currentRecord = [];

        foreach ($lines as $line) {
            // Split the line into key and value
            $parts = array_map('trim', explode(':', $line, 2));

            if (count($parts) === 2) {
                [$key, $value] = $parts;
                $currentRecord[$key] = $value;
            }

            if (empty($line)) {
                $parsedData[] = $currentRecord;
                $currentRecord = [];
            }
        }

        return $parsedData;
    }
}

