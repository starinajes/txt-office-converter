<?php

namespace OfficeConverter\Command;

interface CommandInterface {
    /**
     * Запуск команды
     * @param  string  $sourcePath
     *
     * @return mixed
     */
    public function execute(string $sourcePath);
}