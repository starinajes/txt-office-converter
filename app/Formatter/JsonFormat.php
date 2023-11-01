<?php

namespace OfficeConverter\Formatter;

use OfficeConverter\Parser\TxtParser;

/**
 * Класс отвечает за форматирование офисов в JSON.
 */
class JsonFormat implements FormatInterface
{
    public function supports(string $format): bool
    {
        return $format === 'json';
    }

    public function getOutPutPath(): string
    {
        return 'output/offices.json';
    }

    public function convert(string $data): string
    {
        $parsedData = (new TxtParser())->parse($data);

        file_put_contents($this->getOutPutPath(), json_encode($parsedData, JSON_UNESCAPED_UNICODE));

        return $this->getOutPutPath();
    }
}