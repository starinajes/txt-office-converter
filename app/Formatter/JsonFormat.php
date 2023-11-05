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
        return json_encode($parsedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}