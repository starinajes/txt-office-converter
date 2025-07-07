<?php

namespace OfficeConverter\Formatter;

use DOMDocument;
use SimpleXMLElement;

/**
 * Класс отвечает за форматирование офисов в XML.
 */
class XmlFormat implements FormatInterface
{
    public function getTypeFormat(): FormatType
    {
        return FormatType::XML;
    }

    public function parse(mixed $parsedData): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><companies></companies>');
        foreach (is_array($parsedData) ? $parsedData : iterator_to_array($parsedData) as $office) {
            $company = $xml->addChild('company');
            $company->addChild('company-id', $office->id);
            $company->addChild('name', $office->name);
            $company->addChild('address', $office->address);
            $company->addChild('phone', $office->phone);
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
