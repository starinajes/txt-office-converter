<?php

namespace App\Domain\Office\Formatter;

use App\Domain\Office\Entity\Office;

interface FormatInterface
{
    /**
     * @param Office[] $offices
     * @return string
     */
    public function format(array $offices): string;
} 