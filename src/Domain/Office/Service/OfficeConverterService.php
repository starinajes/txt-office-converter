<?php

namespace App\Domain\Office\Service;

use App\Domain\Office\Parser\ParserInterface;
use App\Domain\Office\Formatter\FormatInterface;

class OfficeConverterService
{
    /**
     * @param string $filePath
     * @param ParserInterface $parser
     * @param FormatInterface $formatter
     * @return string
     */
    public function convert(string $filePath, ParserInterface $parser, FormatInterface $formatter): string
    {
        $offices = $parser->parse($filePath);

        return $formatter->format($offices);
    }
} 