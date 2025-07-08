<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Common\Formatter\FormatInterface;
use App\Domain\Common\Entity\EntityInterface;
use SimpleXMLElement;
use DOMDocument;

class XmlFormat implements FormatInterface
{
    public function format(array $entities): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><items></items>');

        foreach ($entities as $entity) {
            $item = $xml->addChild('item');
            foreach ($entity->toArray() as $key => $value) {
                $item->addChild($key, htmlspecialchars((string)$value));
            }
        }

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        return $dom->saveXML();
    }
} 