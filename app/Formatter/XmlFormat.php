<?php

namespace OfficeConverter\Formatter;

use OfficeConverter\Parser\TxtParser;

/**
 * Класс отвечает за форматирование офисов в XML.
 */
class XmlFormat implements FormatInterface
{
    public function supports(string $format): bool
    {
        return $format === 'xml';
    }

    public function getOutPutPath(): string
    {
        return 'output/offices.xml';
    }

    public function convert(string $data): string
    {
        $parsedData = (new TxtParser())->parse($data);
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><companies></companies>');

        foreach ($parsedData as $record) {
            $company = $xml->addChild('company');

            foreach ($record as $key => $value) {
                // Handle different keys as needed
                if ($key === 'id') {
                    $company->addChild('company-id', $value);
                } elseif ($key === 'name') {
                    $company->addChild('name', $value);
                } elseif ($key === 'address') {
                    $company->addChild('address', $value);
                } elseif ($key === 'phone') {
                    $phone = $company->addChild('phone');
                    $phone->addChild('type', 'phone');
                    $phone->addChild('number', $value);
                }
            }
        }

        file_put_contents($this->getOutPutPath(), $xml->asXML());

        return $this->getOutPutPath();
    }
}
