<?php

namespace App\Infrastructure\Parser;

use App\Domain\Common\Parser\ParserInterface;
use App\Domain\Office\Entity\Office;
use RuntimeException;
use SplFileObject;

class TxtOfficeParser implements ParserInterface
{
    /** @throws RuntimeException */
    public function parse(string $filePath): array
    {
        if (!is_readable($filePath)) {
            throw new RuntimeException("Файл недоступен: $filePath");
        }

        $file = new SplFileObject($filePath, 'rb');
        $file->setFlags(
            SplFileObject::DROP_NEW_LINE
            | SplFileObject::READ_AHEAD
        );

        $offices = [];
        $current = [];

        foreach ($file as $raw) {
            if ($raw === false) {
                continue;
            }

            $line = trim(str_replace("\u{00A0}", ' ', (string) $raw));

            if ($line === '') {
                $this->pushOffice($offices, $current);
                $current = [];
                continue;
            }

            if (preg_match('/^([\w-]+)\s*:\s*(.+)$/u', $line, $m)) {
                $current[strtolower($m[1])] = $m[2];
            }
        }

        $this->pushOffice($offices, $current);
        return $offices;
    }

    /** @param array<string,string> $data */
    private function pushOffice(array &$list, array $data): void
    {
        if ($data === []) {
            return;
        }

        $list[] = new Office(
            id:      (int)($data['id'] ?? 0),
            name:    $data['name']    ?? '',
            address: $data['address'] ?? '',
            phone:   $data['phone']   ?? ''
        );
    }
}