<?php

namespace Tests\Infrastructure\Parser;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Parser\CsvCarParser;
use App\Domain\Car\Entity\Car;

class CsvCarParserTest extends TestCase
{
    private array $testFiles = [];

    protected function tearDown(): void
    {
        foreach ($this->testFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function testParseCar()
    {
        $file = __DIR__ . '/test_cars.csv';
        file_put_contents($file, "id,brand,model,year\n1,Toyota,Corolla,2018\n2,BMW,320i,2020\n");
        $this->testFiles[] = $file;

        $parser = new CsvCarParser();
        /** @var Car[] $cars */
        $cars = $parser->parse($file);

        if (!is_array($cars)) {
            fwrite(STDERR, "\nCsvCarParser вернул: ".var_export($cars, true)."\n");
        }
        $this->assertIsArray($cars, 'Парсер должен возвращать массив');
        $this->assertNotEmpty($cars, 'Парсер вернул пустой массив, хотя в файле есть данные');
        $this->assertCount(2, $cars);
        $this->assertInstanceOf(Car::class, $cars[0]);
        $this->assertEquals('Toyota', $cars[0]->brand);
    }
} 