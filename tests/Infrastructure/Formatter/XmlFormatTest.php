<?php

namespace Tests\Infrastructure\Formatter;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Formatter\XmlFormat;
use App\Domain\Office\Entity\Office;
use App\Domain\Car\Entity\Car;

class XmlFormatTest extends TestCase
{
    public function testFormatOffice()
    {
        $format = new XmlFormat();
        $offices = [
            new Office(1, 'Офис 1', 'Адрес 1', '123'),
            new Office(2, 'Офис 2', 'Адрес 2', '456'),
        ];
        $xml = $format->format($offices);
        $this->assertStringContainsString('<name>Офис 1</name>', $xml);
    }

    public function testFormatCar()
    {
        $format = new XmlFormat();
        $cars = [
            new Car(1, 'Toyota', 'Corolla', 2018),
            new Car(2, 'BMW', '320i', 2020),
        ];
        $xml = $format->format($cars);
        $this->assertStringContainsString('<brand>Toyota</brand>', $xml);
    }
} 