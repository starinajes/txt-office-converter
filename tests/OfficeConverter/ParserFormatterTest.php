<?php
namespace OfficeConverter;

use Exception;
use OfficeConverter\Formatter\JsonFormat;
use OfficeConverter\Formatter\XmlFormat;
use OfficeConverter\Model\Office;
use OfficeConverter\Parser\ParserFactory;
use OfficeConverter\Parser\TxtParser;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use SplFileObject;

class ParserFormatterTest extends TestCase
{
    /**
     * @throws Exception
     */
    private function getOffices(): array
    {
        $file = new SplFileObject(dirname(__DIR__, 2) . '/storage/offices.txt');
        return new TxtParser()->parse($file);
    }

    /**
     * @throws Exception
     */
    public function testParserReturnsOfficeObjects(): void
    {
        $offices = $this->getOffices();

        $this->assertCount(3, $offices);
        $this->assertContainsOnlyInstancesOf(Office::class, $offices);

        $first = $offices[0];

        $this->assertEquals('1375', $first->id);
        $this->assertSame('До «Воздвиженское»', $first->name);
        $this->assertSame('г.Москва улица Воздвиженка дом 10', $first->address);
        $this->assertSame('8-800-775-86-86', $first->phone);
    }

    /**
     * @throws Exception
     */
    public function testJsonFormatterSerializesCollection(): void
    {
        $offices = $this->getOffices();
        $json = new JsonFormat()->format($offices);
        $data = json_decode($json, true);

        $this->assertCount(3, $data);
        $this->assertEquals('1375', $data[0]['id']);
        $this->assertSame('До «Мира проспект»', $data[1]['name']);
    }

    /**
     * @throws Exception
     */
    public function testXmlFormatterSerializesCollection(): void
    {
        $offices = $this->getOffices();
        $xml = new XmlFormat()->format($offices);
        $xmlObj = new SimpleXMLElement($xml);

        $this->assertCount(3, $xmlObj->company);
        $this->assertSame('1375', (string)$xmlObj->company[0]->{'company-id'});
    }

    /**
     * @throws Exception
     */
    public function testParserHandlesEmptyFile(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'empty');
        $file = new SplFileObject($tmp, 'r');
        $offices = new TxtParser()->parse($file);

        $this->assertIsArray($offices);
        $this->assertCount(0, $offices);

        unlink($tmp);
    }

    /**
     * @throws Exception
     */
    public function testParserHandlesMalformedFile(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'malformed');
        file_put_contents($tmp, "id: 1\nname\naddress: test\n");
        $file = new SplFileObject($tmp, 'r');
        $offices = new TxtParser()->parse($file);

        $this->assertIsArray($offices);
        $this->assertCount(1, $offices);
        $this->assertSame('', $offices[0]->name);

        unlink($tmp);
    }

    public function testJsonFormatterHandlesEmptyCollection(): void
    {
        $json = new JsonFormat()->format([]);
        $data = json_decode($json, true);

        $this->assertIsArray($data);
        $this->assertCount(0, $data);
    }

    /**
     * @throws Exception
     */
    public function testXmlFormatterHandlesEmptyCollection(): void
    {
        $xml = new XmlFormat()->format([]);
        $xmlObj = new SimpleXMLElement($xml);

        $this->assertCount(0, $xmlObj->company);
    }

    /**
     * @throws Exception
     */
    public function testParserFactoryReturnsCorrectParser()
    {
        $parser = ParserFactory::createParser('file.txt');
        $this->assertInstanceOf(\OfficeConverter\Parser\TxtParser::class, $parser);
    }
}