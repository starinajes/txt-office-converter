<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\JsonFormat;

/**
 * Команда запуска конвертирования для JSON файлов
 */
class JsonConvertCommand extends CommandBase
{
    public function getFormatter(): JsonFormat
    {
        return new JsonFormat();
    }
}