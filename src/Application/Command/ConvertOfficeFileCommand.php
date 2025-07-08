<?php

namespace App\Application\Command;

readonly class ConvertOfficeFileCommand
{
    public function __construct(
        public string $sourcePath,
        public string $format
    ) {}
} 