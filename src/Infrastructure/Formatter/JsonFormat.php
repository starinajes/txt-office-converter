<?php

namespace App\Infrastructure\Formatter;

use App\Domain\Office\Formatter\FormatInterface;
use App\Domain\Office\Entity\Office;

class JsonFormat implements FormatInterface
{
    public function format(array $offices): string
    {
        $data = array_map(function (Office $office) {
            return [
                'id'      => $office->id,
                'name'    => $office->name,
                'address' => $office->address,
                'phone'   => $office->phone,
            ];
        }, $offices);

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
} 