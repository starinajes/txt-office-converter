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
        $fieldToXmlMapping = $this->getMapFields();

        foreach ($parsedData as $record) {
            $company = $xml->addChild('company');

            foreach ($record as $key => $value) {
                if (isset($fieldToXmlMapping[$key])) {
                    $elementName = $fieldToXmlMapping[$key];
                    $company->addChild($elementName, $value);
                }
            }
        }

        $xmlString = $xml->asXML();

        return $this->formatXML($xmlString);
    }

    /**
     * Маппинг полей с файлом
     * todo: можно перейти на Model и связать поля
     *
     * @return string[]
     */
    private function getMapFields(): array
    {
        return [
            'id'      => 'company-id',
            'name'    => 'name',
            'address' => 'address',
            'phone'   => 'phone',
        ];
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
