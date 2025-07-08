<?php
namespace App\Infrastructure\Parser;

use App\Domain\Common\Parser\ParserInterface;
use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Car\Entity\Car;
use RuntimeException;

class CsvCarParser implements ParserInterface
{
    /**
     * @param string $filePath
     * @return EntityInterface[]
     */
    public function parse(string $filePath): array
    {
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new RuntimeException("Не удалось открыть файл: $filePath");
        }

        $cars = [];
        fgetcsv($handle, 0);

        while (($row = fgetcsv($handle, 0)) !== false) {
            [$id, $brand, $model, $year] = $row;

            $cars[] = new Car(
                id: (int)$id,
                brand: $brand,
                model: $model,
                year: (int)$year);
        }

        fclose($handle);

        return $cars;
    }
} 