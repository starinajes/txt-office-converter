<?php

namespace App\Domain\Office\Entity;

readonly class Office
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $phone
    ) {}
} 