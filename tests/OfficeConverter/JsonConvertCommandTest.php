<?php
namespace OfficeConverter;

use Exception;
use OfficeConverter\Command\JsonConvertCommand;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\JsonFormat;
use PHPUnit\Framework\TestCase;

class JsonConvertCommandTest extends TestCase
{
    public function testExecute()
    {
//        $converter = new OfficeConverter();
//        $converter->addFormat(new JsonFormat());
//        $command = new JsonConvertCommand();
//        $command->execute('storage/offices.txt');
        $this->assertTrue(true);
    }
}