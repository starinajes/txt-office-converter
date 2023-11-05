<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\XmlFormat;

/**
 * Команда запуска конвертирования для XML файлов
 */
class XmlConvertCommand extends CommandBase
{
    public function getFormatterClass(): XmlFormat
    {
        return new XmlFormat();
    }
}
