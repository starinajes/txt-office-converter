<?php

namespace Tests\Infrastructure\Formatter;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Formatter\JsonFormat;
use App\Domain\Office\Entity\Office;
use App\Domain\Car\Entity\Car;

class JsonFormatTest extends TestCase
{
    public function testFormatOffice()
    {
        $format = new JsonFormat();
        $offices = [
            new Office(1, 'Офис 1', 'Адрес 1', '123'),
            new Office(2, 'Офис 2', 'Адрес 2', '456'),
        ];
        $json = $format->format($offices);
        $this->assertJson($json);
        $data = json_decode($json, true);
        $this->assertEquals('Офис 1', $data[0]['name']);
    }

    public function testFormatCar()
    {
        $format = new JsonFormat();
        $cars = [
            new Car(1, 'Toyota', 'Corolla', 2018),
            new Car(2, 'BMW', '320i', 2020),
        ];
        $json = $format->format($cars);
        $this->assertJson($json);
        $data = json_decode($json, true);
        $this->assertEquals('Toyota', $data[0]['brand']);
    }
} 