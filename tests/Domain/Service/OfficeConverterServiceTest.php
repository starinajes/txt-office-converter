<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Office\Service\OfficeConverterService;
use App\Domain\Office\Parser\ParserInterface;
use App\Domain\Office\Formatter\FormatInterface;

class OfficeConverterServiceTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testConvertReturnsFormattedString()
    {
        $parser = $this->createMock(ParserInterface::class);
        $formatter = $this->createMock(FormatInterface::class);
        $parser->method('parse')->willReturn([1,2,3]);
        $formatter->method('format')->willReturn('formatted');

        $service = new OfficeConverterService();
        $result = $service->convert('file.txt', $parser, $formatter);

        $this->assertEquals('formatted', $result);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testConvertWithEmptyResult()
    {
        $parser = $this->createMock(ParserInterface::class);
        $formatter = $this->createMock(FormatInterface::class);
        $parser->method('parse')->willReturn([]);
        $formatter->method('format')->willReturn('empty');

        $service = new OfficeConverterService();
        $result = $service->convert('file.txt', $parser, $formatter);

        $this->assertEquals('empty', $result);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testFormatterThrowsException()
    {
        $parser = $this->createMock(ParserInterface::class);
        $formatter = $this->createMock(FormatInterface::class);
        $parser->method('parse')->willReturn([1]);
        $formatter->method('format')->willThrowException(new \Exception('fail'));

        $service = new OfficeConverterService();
        $this->expectException(\Exception::class);

        $service->convert('file.txt', $parser, $formatter);
    }
} 