<?php

namespace App\Domain\Car\Entity;

use App\Domain\Common\Entity\EntityInterface;

readonly class Car implements EntityInterface
{
    public function __construct(
        public int $id,
        public string $brand,
        public string $model,
        public int $year
    ) {}

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'year'  => $this->year,
        ];
    }
} 