<?php

namespace Tests\Infrastructure\Config;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Config\Paths;

class PathsTest extends TestCase
{
    public function testOutputPathConstant()
    {
        $this->assertStringContainsString('/output/', Paths::getOutputPath());
        $this->assertDirectoryExists(dirname(Paths::getOutputPath()));
    }

    public function testStoragePathConstant()
    {
        $this->assertStringContainsString('/storage/', Paths::getStoragePath());
        $this->assertDirectoryExists(dirname(Paths::getStoragePath()));
    }
} 