<?php

namespace App\Application\Command\DTO;

readonly class ConvertResultDTO
{
    public function __construct(
        public string $inputFile,
        public string $outputFile,
        public string $format
    ) {}
} 