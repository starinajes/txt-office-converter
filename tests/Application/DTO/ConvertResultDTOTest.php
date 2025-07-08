<?php

namespace Tests\Application\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Command\DTO\ConvertResultDTO;

class ConvertResultDTOTest extends TestCase
{
    public function testDTOStoresData()
    {
        $dto = new ConvertResultDTO('input.txt', 'output.json', 'json');

        $this->assertEquals('input.txt', $dto->inputFile);
        $this->assertEquals('output.json', $dto->outputFile);
        $this->assertEquals('json', $dto->format);
    }
} 