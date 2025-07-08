<?php

namespace App\Infrastructure\Parser;

use App\Domain\Office\Parser\ParserInterface;
use App\Domain\Office\Entity\Office;
use App\Infrastructure\Config\Paths;

class TxtParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $offices = [];
        $current = [];
        $fullPath = Paths::STORAGE . $filePath;

        foreach (file($fullPath) as $line) {
            $line = trim($line);

            if ($line === '') {
                if ($current) {
                    $offices[] = new Office(
                        id: (int)($current['id'] ?? 0),
                        name: $current['name'] ?? '',
                        address: $current['address'] ?? '',
                        phone: $current['phone'] ?? ''
                    );
                    $current = [];
                }
                continue;
            }

            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $current[trim($key)] = trim($value);
            }
        }

        if ($current) {
            $offices[] = new Office(
                id: (int)($current['id'] ?? 0),
                name: $current['name'] ?? '',
                address: $current['address'] ?? '',
                phone: $current['phone'] ?? ''
            );
        }

        return $offices;
    }
} 