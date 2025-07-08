<?php

namespace Tests\Infrastructure\Config;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Config\Paths;

class PathsTest extends TestCase
{
    public function testOutputPathConstant()
    {
        $this->assertStringContainsString('/output/', Paths::OUTPUT);
        $this->assertDirectoryExists(dirname(Paths::OUTPUT));
    }

    public function testStoragePathConstant()
    {
        $this->assertStringContainsString('/storage/', Paths::STORAGE);
        $this->assertDirectoryExists(dirname(Paths::STORAGE));
    }
} 