<?php

namespace Tests\Application\Registry;

use Exception;
use PHPUnit\Framework\TestCase;
use App\Application\Command\CommandRegistry;
use App\Application\Command\ConvertOfficeFileHandler;

class CommandRegistryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetCommandReturnsHandler()
    {
        $handler = CommandRegistry::getCommand('convert');
        $this->assertInstanceOf(ConvertOfficeFileHandler::class, $handler);
    }

    public function testGetCommandThrowsOnUnknown()
    {
        $this->expectException(Exception::class);
        CommandRegistry::getCommand('unknown');
    }
} 