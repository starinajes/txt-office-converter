<?php

namespace Tests\Infrastructure\Factory;

use App\Infrastructure\Parser\TxtOfficeParser;
use Exception;
use PHPUnit\Framework\TestCase;
use App\Infrastructure\Parser\ParserFactory;

class ParserFactoryTest extends TestCase
{
    public function testCreateTxtParser()
    {
        $parser = ParserFactory::create('file.txt');
        $this->assertInstanceOf(TxtOfficeParser::class, $parser);
    }

    public function testCreateUnknownExtensionThrows()
    {
        $this->expectException(Exception::class);
        ParserFactory::create('file.unknown');
    }
} 