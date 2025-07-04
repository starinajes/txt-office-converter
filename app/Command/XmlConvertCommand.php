<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\XmlFormat;
use OfficeConverter\Parser\TxtParser;

/**
 * Команда запуска конвертирования для XML файлов
 */
class XmlConvertCommand extends CommandBase
{
    public function getFormatterClass(): XmlFormat
    {
        return new XmlFormat(new TxtParser());
    }
}
