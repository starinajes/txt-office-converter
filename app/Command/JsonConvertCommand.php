<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\JsonFormat;

/**
 * Команда запуска конвертирования для JSON файлов
 */
class JsonConvertCommand extends CommandBase
{
    public function getFormatterClass(): JsonFormat
    {
        return new JsonFormat();
    }
}