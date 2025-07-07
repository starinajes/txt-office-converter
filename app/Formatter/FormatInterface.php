<?php

namespace OfficeConverter\Formatter;

/**
 * Интерфейс для работы с форматами
 */
interface FormatInterface
{
    /**
     * Метод парсит полученные данные
     * @param  mixed  $parsedData
     *
     * @return mixed
     */
    public function format(array $parsedData): string;
}