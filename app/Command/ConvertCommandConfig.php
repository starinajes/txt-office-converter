<?php

namespace OfficeConverter\Command;

readonly class ConvertCommandConfig
{
    public function __construct(
        public string $sourcePath,
        public string $targetFormat,
    ) {}
} 