<?php

namespace OfficeConverter\Formatter;

use DOMDocument;
use SimpleXMLElement;

/**
 * Класс отвечает за форматирование офисов в XML.
 */
class XmlFormat extends FormatBase
{
    public function getTypeFormat(): string
    {
        return 'xml';
    }

    public function parse(mixed $parsedData): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><companies></companies>');
        foreach ($parsedData as $office) {
            $company = $xml->addChild('company');
            $company->addChild('company-id', $office->getId());
            $company->addChild('name', $office->getName());
            $company->addChild('address', $office->getAddress());
            $company->addChild('phone', $office->getPhone());
        }

        $xmlString = $xml->asXML();

        return $this->formatXML($xmlString);
    }

    /**
     * Конфиг вывода xml
     * @param $xml
     *
     * @return false|string
     */
    private function formatXML($xml): false|string
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        return $dom->saveXML();
    }
}
