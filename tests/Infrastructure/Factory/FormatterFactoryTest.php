<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Formatter\FormatterFactory;
use App\Infrastructure\Formatter\JsonFormat;
use App\Infrastructure\Formatter\XmlFormat;

class FormatterFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateJsonFormat()
    {
        $formatter = FormatterFactory::create('json');
        $this->assertInstanceOf(JsonFormat::class, $formatter);
    }

    /**
     * @throws Exception
     */
    public function testCreateXmlFormat()
    {
        $formatter = FormatterFactory::create('xml');
        $this->assertInstanceOf(XmlFormat::class, $formatter);
    }

    public function testCreateUnknownFormatThrows()
    {
        $this->expectException(Exception::class);
        FormatterFactory::create('unknown');
    }
} 