<?php

namespace OfficeConverter\Formatter;

/**
 * Класс отвечает за форматирование офисов в JSON.
 */
class JsonFormat extends FormatBase
{
    /**
     *
     * @return string
     */
    public function getTypeFormat(): string
    {
        return 'json';
    }

    /**
     * @param  mixed  $parsedData
     *
     * @return string|false
     */
    public function parse(mixed $parsedData): string|false
    {
        $data = array_map(static function ($office) {
            return [
                'id'      => $office->getId(),
                'name'    => $office->getName(),
                'address' => $office->getAddress(),
                'phone'   => $office->getPhone(),
            ];
        }, $parsedData);

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}