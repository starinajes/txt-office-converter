<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Formatter\XmlFormat;
use App\Domain\Office\Entity\Office;

class XmlFormatTest extends TestCase
{
    public function testXmlFormatterSerializesCollection()
    {
        $formatter = new XmlFormat();
        $offices = [new Office(1, 'Test', 'Addr', '123')];
        $xml = $formatter->format($offices);

        $this->assertStringContainsString('<company>', $xml);
    }

    public function testXmlFormatterHandlesEmptyCollection()
    {
        $formatter = new XmlFormat();
        $xml = $formatter->format([]);

        $this->assertStringContainsString('<companies', $xml);
    }
} 