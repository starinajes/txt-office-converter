<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\FormatBase;

interface CommandInterface {
    /**
     * Запуск команды
     * @param  string  $sourcePath
     *
     */
    public function execute(string $sourcePath): void;

    /**
     * @return mixed
     */
    public function getFormatterClass(): FormatBase;
}