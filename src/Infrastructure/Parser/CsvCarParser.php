<?php
namespace App\Infrastructure\Parser;

use App\Domain\Common\Parser\ParserInterface;
use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Car\Entity\Car;
use RuntimeException;
use SplFileObject;

class CsvCarParser implements ParserInterface
{
    /**
     * @throws RuntimeException
     *
     * @return EntityInterface[]
     */
    public function parse(string $filePath): array
    {
        if (!is_readable($filePath)) {
            throw new RuntimeException("Файл не найден или недоступен: $filePath");
        }

        $file = new SplFileObject($filePath, 'rb');
        $file->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE
        );

        $cars = [];
        $first = true;
        foreach ($file as $row) {
            if ($first) { $first = false; continue; } // пропустить заголовок
            if (!is_array($row) || $row === [null] || count($row) < 4) {
                continue; // пустая или битая строка
            }

            [$id, $brand, $model, $year] = $row;
            $cars[] = new Car(
                id:    (int) $id,
                brand: $brand,
                model: $model,
                year:  (int) $year,
            );
        }

        return $cars;
    }
} 