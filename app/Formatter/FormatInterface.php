<?php

namespace OfficeConverter\Formatter;

use SplFileObject;

/**
 * Интерфейс для работы с форматтерами
 */
interface FormatInterface
{
    /**
     * Функция конвертирования
     *
     * @param  SplFileObject  $data
     *
     * @return string
     */
    public function convert(SplFileObject $data): string;

    /**
     * Метод получения типа форматтера
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

    /**
     * Метод проверки, какой формат поддерживается классом
     * @param  string  $format
     *
     * @return bool
     */
    public function isSupportFormat(string $format): bool;
}