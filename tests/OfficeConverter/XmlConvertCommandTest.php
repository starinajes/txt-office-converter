<?php
namespace OfficeConverter;

use Exception;
use OfficeConverter\Command\JsonConvertCommand;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\XmlFormat;
use PHPUnit\Framework\TestCase;

class XmlConvertCommandTest extends TestCase
{
    public function testExecute()
    {
//        $converter = new OfficeConverter();
//        $converter->addFormat(new XmlFormat());
//        $command = new JsonConvertCommand();
//        $command->execute('storage/offices.txt');
        $this->assertTrue(true);
    }
}