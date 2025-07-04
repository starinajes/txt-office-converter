<?php

namespace OfficeConverter\Parser;

use Exception;
use SplFileObject;
use OfficeConverter\Model\Office;

/**
 * Парсер TXT файлов
 */
class TxtParser implements ParserInterface
{
    /**
     * @throws Exception
     */
    public function parse(SplFileObject $data): array
    {
        $parsedData = [];
        $currentRecord = [];

        // на входе итератор для построчного чтения файла, вдруг файл большой
        foreach ($data as $line) {
            $line = trim($line);

            if (empty($line) && !empty($currentRecord)) {
                // Если строка пустая и есть текущая запись, добавляем ее в результат
                $parsedData[] = $this->createOffice($currentRecord);
                $currentRecord = [];
            } else {
                $parts = array_map('trim', explode(':', $line, 2));

                if (count($parts) === 2) {
                    [$key, $value] = $parts;
                    $currentRecord[$key] = $value;
                }
            }
        }

        // Добавляем последнюю запись, если она не была завершена
        if (!empty($currentRecord)) {
            $parsedData[] = $this->createOffice($currentRecord);
        }

        return $parsedData;
    }

    private function createOffice(array $record): Office
    {
        return new Office(
            $record['id'] ?? null,
            $record['name'] ?? null,
            $record['address'] ?? null,
            $record['phone'] ?? null
        );
    }
}

