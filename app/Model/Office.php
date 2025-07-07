<?php

declare(strict_types=1);

namespace OfficeConverter\Model;

/**
 * Модель офиса.
 *
 */
final readonly class Office
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $phone
    ) {}
}
