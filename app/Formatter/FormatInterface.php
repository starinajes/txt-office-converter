<?php

namespace OfficeConverter\Formatter;

/**
 * Интерфейс для работы с форматами
 */
interface FormatInterface
{
    /**
     * Метод получения типа формата
     * @return FormatType
     */
    public function getTypeFormat(): FormatType;

    /**
     * Метод парсит полученные данные
     * @param  mixed  $parsedData
     *
     * @return mixed
     */
    public function parse(mixed $parsedData): mixed;
}