<?php

namespace App\Domain\Office\Formatter;

interface FormatInterface
{
    /**
     * @param array $offices // Office[]
     * @return string
     */
    public function format(array $offices): string;
} 