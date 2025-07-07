<?php
namespace OfficeConverter;

use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatInterface;
use OfficeConverter\Formatter\FormatType;
use OfficeConverter\Formatter\JsonFormat;
use OfficeConverter\Formatter\XmlFormat;
use OfficeConverter\Parser\TxtParser;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use SplFileObject;

class OfficeConverterTest extends TestCase
{
    /**
     * @throws Exception
     * @throws \Exception
     */
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
            ->method('convert')
            ->with($this->isInstanceOf(SplFileObject::class))
            ->willReturn('converted');

        $format->expects($this->any())
            ->method('getTypeFormat')
            ->willReturn(FormatType::JSON);

        $converter->addFormat($format);

        $converter->convert('offices.txt', FormatType::JSON);
    }

    /**
     * @throws \Exception
     */
    public function testConvertWithRealJsonFormat()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }
        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }
        $converter = new OfficeConverter();

        $converter->addFormat(new JsonFormat(new TxtParser()));
        $converter->convert('offices.txt', FormatType::JSON);
        $converter->saveConvertedDataToFile('offices.txt', 'json');
        $resultPath = $converter->getOutPathToResult();

        $this->assertFileExists($resultPath);

        $json = file_get_contents($resultPath);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertCount(3, $data);
    }

    /**
     * @throws \Exception
     */
    public function testConvertWithRealXmlFormat()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }
        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }
        $converter = new OfficeConverter();

        $converter->addFormat(new XmlFormat(new TxtParser()));
        $converter->convert('offices.txt', FormatType::XML);
        $converter->saveConvertedDataToFile('offices.txt', 'xml');
        $resultPath = $converter->getOutPathToResult();

        $this->assertFileExists($resultPath);

        $xml = file_get_contents($resultPath);
        $xmlObj = new SimpleXMLElement($xml);

        $this->assertCount(3, $xmlObj->company);
    }

    public function testConvertThrowsIfNoFormat()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }
        $converter = new OfficeConverter();

        $this->expectException(\Exception::class);

        $converter->convert('offices.txt', FormatType::JSON);
    }
}