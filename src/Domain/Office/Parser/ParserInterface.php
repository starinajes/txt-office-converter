<?php

namespace App\Domain\Office\Parser;

use App\Domain\Office\Entity\Office;

interface ParserInterface
{
    /**
     * @param string $filePath
     * @return Office[]
     */
    public function parse(string $filePath): array;
} 