<?php

namespace App\Domain\Office\Parser;

interface ParserInterface
{
    /**
     * @param string $filePath
     * @return array // Office[]
     */
    public function parse(string $filePath): array;
} 