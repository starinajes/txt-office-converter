<?php
namespace OfficeConverter;

use Exception;
use OfficeConverter\Command\XmlConvertCommand;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatType;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class XmlConvertCommandTest extends TestCase
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
        $expectedFile = __DIR__ . '/../../output/offices.xml';

        if (file_exists($expectedFile)) {
            unlink($expectedFile);
        }

        $converter = new OfficeConverter();
        $command = new XmlConvertCommand($converter);
        $resultPath = $command->execute($source, FormatType::XML);

        $this->assertFileExists($expectedFile);
        $this->assertSame(realpath($expectedFile), realpath($resultPath));

        $xml = file_get_contents($expectedFile);
        $xmlObj = new SimpleXMLElement($xml);

        $this->assertCount(3, $xmlObj->company);
        $this->assertSame('1375', (string)$xmlObj->company[0]->{'company-id'});
    }
}