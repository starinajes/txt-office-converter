<?php

namespace Tests\Application\Command;

use PHPUnit\Framework\TestCase;
use App\Application\Command\ConvertFileHandler;
use App\Application\Command\ConvertFileCommand;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;
use App\Domain\Office\Entity\Office;
use App\Domain\Car\Entity\Car;

class ConvertFileHandlerTest extends TestCase
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

    /**
     * @throws \Exception
     */
    public function testHandleOfficeToJson()
    {
        $file = __DIR__ . '/test_offices.txt';
        file_put_contents($file, "id: 1\nname: Офис 1\naddress: Адрес 1\nphone: 123\n\nid: 2\nname: Офис 2\naddress: Адрес 2\nphone: 456\n");
        $this->testFiles[] = $file;

        $handler = new ConvertFileHandler(new ParserFactory(), new FormatterFactory());
        $command = new ConvertFileCommand($file, 'json');
        $dto = $handler->handle($command);

        $outputFile = realpath($dto->outputFile) ?: $dto->outputFile;
        $this->assertFileExists($outputFile);
        $this->testFiles[] = $outputFile;

        $json = file_get_contents($outputFile);
        $this->assertStringContainsString('Офис 1', $json);
    }

    public function testHandleCarToXml()
    {
        $file = __DIR__ . '/test_cars.csv';
        file_put_contents($file, "id,brand,model,year\n1,Toyota,Corolla,2018\n2,BMW,320i,2020\n");
        $this->testFiles[] = $file;

        $handler = new ConvertFileHandler(new ParserFactory(), new FormatterFactory());
        $command = new ConvertFileCommand($file, 'xml');
        $dto = $handler->handle($command);
        $outputFile = realpath($dto->outputFile) ?: $dto->outputFile;

        $this->assertFileExists($outputFile);
        $this->testFiles[] = $outputFile;

        $xml = file_get_contents($outputFile);
        $this->assertStringContainsString('<brand>Toyota</brand>', $xml);
    }
} 