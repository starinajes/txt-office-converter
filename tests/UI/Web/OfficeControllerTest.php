<?php

namespace Tests\UI\Web;

use PHPUnit\Framework\TestCase;
use App\UI\Web\OfficeController;

class OfficeControllerTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testConvertActionSuccess()
    {
        $controller = new OfficeController();
        $result = $controller->convertAction(['file' => 'offices.txt', 'format' => 'json']);

        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('output', $result);
        $this->assertStringContainsString('offices.txt', $result['message']);
        $this->assertStringContainsString('json', $result['message']);
    }

    public function testConvertActionUnknownFormat()
    {
        $controller = new OfficeController();

        $this->expectException(\Exception::class);
        $controller->convertAction(['file' => 'offices.txt', 'format' => 'unknown']);
    }
} 