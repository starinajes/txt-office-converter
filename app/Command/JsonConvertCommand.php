<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\JsonFormat;
use OfficeConverter\Parser\TxtParser;

/**
 * Команда запуска конвертирования для JSON файлов
 */
class JsonConvertCommand extends CommandBase
{
    public function getFormatter(): JsonFormat
    {
        return new JsonFormat(new TxtParser());
    }
}