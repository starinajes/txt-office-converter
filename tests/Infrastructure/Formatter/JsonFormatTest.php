<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Formatter\JsonFormat;
use App\Domain\Office\Entity\Office;

class JsonFormatTest extends TestCase
{
    public function testJsonFormatterSerializesCollection()
    {
        $formatter = new JsonFormat();
        $offices = [new Office(1, 'Test', 'Addr', '123')];
        $json = $formatter->format($offices);

        $this->assertStringContainsString('Test', $json);
    }

    public function testJsonFormatterHandlesEmptyCollection()
    {
        $formatter = new JsonFormat();
        $json = $formatter->format([]);

        $this->assertStringContainsString('[]', $json);
    }
} 