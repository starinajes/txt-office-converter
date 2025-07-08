<?php

namespace Tests\Infrastructure\Parser;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Parser\TxtOfficeParser;
use App\Domain\Office\Entity\Office;

class TxtParserTest extends TestCase
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

    public function testParseOffice()
    {
        $file = __DIR__ . '/test_offices.txt';
        file_put_contents($file, "id: 1\nname: Офис 1\naddress: Адрес 1\nphone: 123\n\nid: 2\nname: Офис 2\naddress: Адрес 2\nphone: 456\n");
        $this->testFiles[] = $file;
        $parser = new TxtOfficeParser();

        /** @var Office[] $offices */
        $offices = $parser->parse($file);

        $this->assertCount(2, $offices);
        $this->assertInstanceOf(Office::class, $offices[0]);
        $this->assertEquals('Офис 1', $offices[0]->name);
    }
} 