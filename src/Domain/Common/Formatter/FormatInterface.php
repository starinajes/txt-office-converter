<?php
namespace App\Domain\Common\Formatter;

use App\Domain\Common\Entity\EntityInterface;

interface FormatInterface
{
    /**
     * @param EntityInterface[] $entities
     * @return string
     */
    public function format(array $entities): string;
} 