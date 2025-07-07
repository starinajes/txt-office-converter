<?php
namespace OfficeConverter;

use Exception;
use OfficeConverter\Command\JsonConvertCommand;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatType;
use PHPUnit\Framework\TestCase;

class JsonConvertCommandTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecute()
    {
        if (!defined('STORAGE_DIR_PATH')) {
            define('STORAGE_DIR_PATH', __DIR__ . '/../../storage/');
        }

        if (!defined('OUTPUT_DIR_PATH')) {
            define('OUTPUT_DIR_PATH', __DIR__ . '/../../output/');
        }
        $source = 'offices.txt';
        $expectedFile = __DIR__ . '/../../output/offices.json';

        if (file_exists($expectedFile)) {
            unlink($expectedFile);
        }
        $converter = new OfficeConverter();
        $command = new JsonConvertCommand($converter);
        $resultPath = $command->execute($source, FormatType::JSON);

        $this->assertFileExists($expectedFile);
        $this->assertSame(realpath($expectedFile), realpath($resultPath));

        $json = file_get_contents($expectedFile);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertCount(3, $data);
        $this->assertSame('1375', (string)$data[0]['id']);
        $this->assertSame('До «Мира проспект»', $data[1]['name']);
    }
}