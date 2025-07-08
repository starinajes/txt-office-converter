<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Office\Formatter\FormatInterface;
use SimpleXMLElement;
use DOMDocument;

class XmlFormat implements FormatInterface
{
    public function format(array $offices): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><companies></companies>');

        foreach ($offices as $office) {
            $company = $xml->addChild('company');
            $company->addChild('company-id', $office->id);
            $company->addChild('name', $office->name);
            $company->addChild('address', $office->address);
            $company->addChild('phone', $office->phone);
        }

        $xmlString = $xml->asXML();

        return $this->formatXML($xmlString);
    }

    private function formatXML($xml): false|string
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        return $dom->saveXML();
    }
} 