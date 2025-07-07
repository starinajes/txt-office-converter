<?php

namespace OfficeConverter\Formatter;

/**
 * Класс отвечает за форматирование офисов в JSON.
 */
class JsonFormat implements FormatInterface
{
    /**
     *
     * @return FormatType
     */
    public function getTypeFormat(): FormatType
    {
        return FormatType::JSON;
    }

    /**
     * @param  mixed  $parsedData
     *
     * @return string
     */
    public function format(mixed $parsedData): string
    {
        $data = array_map(static function ($office) {
            return [
                'id'      => $office->id,
                'name'    => $office->name,
                'address' => $office->address,
                'phone'   => $office->phone,
            ];
        }, is_array($parsedData) ? $parsedData : iterator_to_array($parsedData));

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}