<?php

namespace OfficeConverter\Parser;

use SplFileObject;

/**
 * Интерфейс парсера
 */
interface ParserInterface
{
    /**
     * Функция запуска парсинга
     * @param  SplFileObject  $data
     * @return object[]
     */
    public function parse(SplFileObject $data): array;
}