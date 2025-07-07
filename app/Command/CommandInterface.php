<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\FormatBase;
use OfficeConverter\Formatter\FormatType;

interface CommandInterface {
    /**
     * Запуск команды
     * @param  string  $sourcePath
     * @param  FormatType $formatType
     * @return string
     */
    public function execute(string $sourcePath, FormatType $formatType): string;

    /**
     * @return mixed
     */
    public function getFormatter(): FormatBase;
}