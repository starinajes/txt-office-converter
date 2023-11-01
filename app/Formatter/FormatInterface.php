<?php

namespace OfficeConverter\Formatter;

/**
 *
 */
interface FormatInterface
{
    /**
     * Получение формата файла
     * @param  string  $format
     *
     * @return bool
     */
    public function supports(string $format): bool;

    /**
     * Функция конвертирования
     * @param  string  $data
     *
     * @return string
     */
    public function convert(string $data): string;

    /**
     * Получение адреса выходного файла
     * @return string
     */
    public function getOutPutPath(): string;
}