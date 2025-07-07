<?php
namespace OfficeConverter;

use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatInterface;
use OfficeConverter\Formatter\JsonFormat;
use OfficeConverter\Formatter\XmlFormat;
use OfficeConverter\Parser\ParserInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

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
            ->method('format')
            ->with($this->isType('array'))
            ->willReturn('converted');

        // Создаём тестовый файл
        $testFile = STORAGE_DIR_PATH . 'testfile.txt';
        file_put_contents($testFile, "id: 1\nname: Test\naddress: Addr\nphone: 123\n");
        $converter->setSourcePath('testfile.txt');
        $converter->addFormatter($format);
        $converter->convert();
        unlink($testFile);
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
        $converter->setSourcePath('offices.txt');
        $converter->addFormatter(new JsonFormat());
        $converter->convert();
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
        $converter->setSourcePath('offices.txt');
        $converter->addFormatter(new XmlFormat());
        $converter->convert();
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
        $this->expectExceptionMessage('Source path not set');

        $converter->convert('json');
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testManualParserOverride()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }

        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }

        $converter = new OfficeConverter();

        $mockParser = $this->createMock(ParserInterface::class);
        $mockParser->expects($this->once())
            ->method('parse')
            ->willReturn([
                (object)['id' => 42, 'name' => 'TestName', 'address' => 'TestAddr', 'phone' => '555']
            ]);

        $converter->addParser($mockParser);
        // Создаём тестовый файл
        $testFile = STORAGE_DIR_PATH . 'testfile.txt';
        file_put_contents($testFile, "id: 1\nname: Test\naddress: Addr\nphone: 123\n");
        $converter->setSourcePath('testfile.txt');
        $converter->addFormatter(new JsonFormat());
        $converter->convert();
        $converter->saveConvertedDataToFile('testfile.txt', 'json');
        $resultPath = $converter->getOutPathToResult();
        $json = file_get_contents($resultPath);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertCount(1, $data);
        $this->assertEquals('TestName', $data[0]['name']);
        $this->assertEquals(42, $data[0]['id']);

        unlink($testFile);
        unlink($resultPath);
    }

    /**
     * @throws \Exception
     */
    public function testFluentInterfaceWorksWithJson()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }

        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }

        $testFile = STORAGE_DIR_PATH . 'fluent_test.txt';
        file_put_contents($testFile, "id: 1\nname: Test\naddress: Addr\nphone: 123\n");

        $converter = new OfficeConverter();
        $converter
            ->setSourcePath('fluent_test.txt')
            ->addFormatter(new JsonFormat())
            ->convert()
            ->saveConvertedDataToFile('fluent_test.txt', 'json');
        $resultPath = $converter->getOutPathToResult();

        $this->assertFileExists($resultPath);

        unlink($testFile);
        unlink($resultPath);
    }

    /**
     * @throws \Exception
     */
    public function testFluentInterfaceWorksWithXml()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }

        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }

        $testFile = STORAGE_DIR_PATH . 'fluent_test2.txt';
        file_put_contents($testFile, "id: 2\nname: Test2\naddress: Addr2\nphone: 456\n");

        $converter = new OfficeConverter();
        $converter
            ->setSourcePath('fluent_test2.txt')
            ->addFormatter(new \OfficeConverter\Formatter\XmlFormat())
            ->convert()
            ->saveConvertedDataToFile('fluent_test2.txt', 'xml');

        $resultPath = $converter->getOutPathToResult();

        $this->assertFileExists($resultPath);

        unlink($testFile);
        unlink($resultPath);
    }

    public function testCliConvertCommandJson()
    {
        $storage = __DIR__ . '/../../storage/';
        $output = __DIR__ . '/../../output/';
        $testFile = $storage . 'cli_test.txt';
        file_put_contents($testFile, "id: 3\nname: CLI\naddress: Addr3\nphone: 789\n");
        $cmd = sprintf('php %s/../../converter convert cli_test.txt to:json', __DIR__);
        shell_exec($cmd);
        $jsonFile = $output . 'cli_test.json';

        $this->assertFileExists($jsonFile);

        unlink($testFile);
        unlink($jsonFile);
    }

    public function testCliConvertCommandXml()
    {
        $storage = __DIR__ . '/../../storage/';
        $output = __DIR__ . '/../../output/';
        $testFile = $storage . 'cli_test2.txt';
        file_put_contents($testFile, "id: 4\nname: CLI2\naddress: Addr4\nphone: 000\n");
        $cmd = sprintf('php %s/../../converter convert cli_test2.txt to:xml', __DIR__);
        shell_exec($cmd);
        $xmlFile = $output . 'cli_test2.xml';

        $this->assertFileExists($xmlFile);

        unlink($testFile);
        unlink($xmlFile);
    }
}