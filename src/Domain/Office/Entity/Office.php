<?php

namespace App\Domain\Office\Entity;

use App\Domain\Common\Entity\EntityInterface;

readonly class Office implements EntityInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $phone
    ) {}

    public function toArray(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'address' => $this->address,
            'phone'   => $this->phone,
        ];
    }
} 