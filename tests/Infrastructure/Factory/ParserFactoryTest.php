<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Parser\TxtParser;

class ParserFactoryTest extends TestCase
{
    public function testCreateTxtParser()
    {
        $parser = ParserFactory::create('file.txt');
        $this->assertInstanceOf(TxtParser::class, $parser);
    }

    public function testCreateUnknownExtensionThrows()
    {
        $this->expectException(\Exception::class);
        ParserFactory::create('file.unknown');
    }
} 