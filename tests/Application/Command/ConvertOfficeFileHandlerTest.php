<?php

use PHPUnit\Framework\TestCase;
use App\Application\Command\ConvertOfficeFileHandler;
use App\Application\Command\ConvertOfficeFileCommand;
use App\Domain\Office\Service\OfficeConverterService;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;

class ConvertOfficeFileHandlerTest extends TestCase
{
    public function testHandleReturnsCorrectString()
    {
        $handler = new ConvertOfficeFileHandler(
            new OfficeConverterService(),
            new ParserFactory(),
            new FormatterFactory()
        );

        $command = new ConvertOfficeFileCommand('offices.txt', 'json');
        $result = $handler->execute($command);

        $this->assertStringContainsString('offices.txt', $result);
        $this->assertStringContainsString('json', $result);
    }

    public function testHandleThrowsOnUnknownFormat()
    {
        $handler = new ConvertOfficeFileHandler(
            new OfficeConverterService(),
            new ParserFactory(),
            new FormatterFactory()
        );

        $this->expectException(Exception::class);

        $handler->execute(new ConvertOfficeFileCommand('offices.txt', 'unknown'));
    }
} 