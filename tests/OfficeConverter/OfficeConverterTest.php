<?php
namespace OfficeConverter;

use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatInterface;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class OfficeConverterTest extends TestCase
{
    public function testConvertUsesPassedFormatter()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }
        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }

        $converter = new OfficeConverter();

        $format = $this->createMock(FormatInterface::class);
        $format->expects($this->once())
            ->method('isSupportFormat')
            ->with('test')
            ->willReturn(true);
        $format->expects($this->once())
            ->method('convert')
            ->with($this->isInstanceOf(SplFileObject::class))
            ->willReturn('converted');

        $converter->addFormat($format);

        $converter->convert('offices.txt', 'test');
    }
}