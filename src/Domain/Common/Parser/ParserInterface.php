<?php
namespace App\Domain\Common\Parser;

use App\Domain\Common\Entity\EntityInterface;

interface ParserInterface
{
    /**
     * @param string $filePath
     * @return EntityInterface[]
     */
    public function parse(string $filePath): array;
} 