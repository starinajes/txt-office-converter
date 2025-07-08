<?php

namespace App\Application\Command;

readonly class ConvertFileCommand
{
    public function __construct(
        public string $sourcePath,
        public string $format,
        public ?string $type = null
    ) {}
} 