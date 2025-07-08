<?php

namespace Tests\Infrastructure\Parser;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Parser\TxtParser;
use App\Domain\Office\Entity\Office;
use App\Infrastructure\Config\Paths;

class TxtParserTest extends TestCase
{
    public function testParserReturnsOfficeObjects()
    {
        $testFile = Paths::STORAGE . 'test_parser.txt';
        file_put_contents($testFile, "id: 1\nname: Test\naddress: Addr\nphone: 123\n");
        $parser = new TxtParser();
        $offices = $parser->parse('test_parser.txt');

        $this->assertIsArray($offices);
        $this->assertInstanceOf(Office::class, $offices[0]);

        unlink($testFile);
    }

    public function testParserHandlesEmptyFile()
    {
        $testFile = Paths::STORAGE . 'empty.txt';
        file_put_contents($testFile, "");

        $parser = new TxtParser();
        $offices = $parser->parse('empty.txt');

        $this->assertIsArray($offices);
        $this->assertCount(0, $offices);

        unlink($testFile);
    }
} 