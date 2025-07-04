<?php
namespace OfficeConverter;

use OfficeConverter\Formatter\JsonFormat;
use OfficeConverter\Formatter\XmlFormat;
use OfficeConverter\Model\Office;
use OfficeConverter\Parser\TxtParser;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class ParserFormatterTest extends TestCase
{
    private function getOffices(): array
    {
        $file = new SplFileObject(dirname(__DIR__, 2) . '/storage/offices.txt');
        return (new TxtParser())->parse($file);
    }

    public function testParserReturnsOfficeObjects(): void
    {
        $offices = $this->getOffices();

        $this->assertCount(3, $offices);
        $this->assertContainsOnlyInstancesOf(Office::class, $offices);

        $first = $offices[0];
        $this->assertSame('1375', $first->getId());
        $this->assertSame('До «Воздвиженское»', $first->getName());
        $this->assertSame('г.Москва улица Воздвиженка дом 10', $first->getAddress());
        $this->assertSame('8-800-775-86-86', $first->getPhone());
    }

    public function testJsonFormatterSerializesCollection(): void
    {
        $offices = $this->getOffices();
        $json = (new JsonFormat(new TxtParser()))->parse($offices);
        $data = json_decode($json, true);

        $this->assertCount(3, $data);
        $this->assertSame('1375', $data[0]['id']);
        $this->assertSame('До «Мира проспект»', $data[1]['name']);
    }

    public function testXmlFormatterSerializesCollection(): void
    {
        $offices = $this->getOffices();
        $xml = (new XmlFormat(new TxtParser()))->parse($offices);
        $xmlObj = new \SimpleXMLElement($xml);

        $this->assertCount(3, $xmlObj->company);
        $this->assertSame('1375', (string)$xmlObj->company[0]->{'company-id'});
    }
}