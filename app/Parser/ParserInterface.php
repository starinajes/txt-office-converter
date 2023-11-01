<?php

namespace OfficeConverter\Parser;

/**
 * Интерфейс парсеров
 */
interface ParserInterface
{
    /**
     * Функция запуска парсинга
     * @param $data
     *
     * @return array
     */
    public function parse($data): array;
}