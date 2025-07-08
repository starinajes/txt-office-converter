<?php

namespace Tests\UI\CLI;

use PHPUnit\Framework\TestCase;
use App\UI\CLI\Kernel;

class KernelTest extends TestCase
{
    public function testHandleWithValidCommand()
    {
        $kernel = new Kernel();
        $result = $kernel->handle(['convert', 'offices.txt', 'to:json']);

        $this->assertEquals(0, $result);
    }

    public function testHandleWithUnknownCommand()
    {
        $kernel = new Kernel();
        ob_start();
        $result = $kernel->handle(['unknown']);
        $output = ob_get_clean();

        $this->assertEquals(1, $result);
        $this->assertStringContainsString('Ошибка', $output);
    }

    public function testHandleWithNoArgs()
    {
        $kernel = new Kernel();
        ob_start();
        $result = $kernel->handle([]);
        $output = ob_get_clean();

        $this->assertEquals(1, $result);
        $this->assertStringContainsString('Использование', $output);
    }
} 