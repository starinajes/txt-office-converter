<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Common\Formatter\FormatInterface;
use App\Domain\Common\Entity\EntityInterface;

class JsonFormat implements FormatInterface
{
    public function format(array $entities): string
    {
        $data = array_map(fn(EntityInterface $entity) => $entity->toArray(), $entities);
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
} 