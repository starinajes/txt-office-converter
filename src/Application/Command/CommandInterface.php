<?php

namespace App\Application\Command;

interface CommandInterface
{
    public static function fromArgs(array $args): object;
    public function execute(ConvertOfficeFileCommand $config): mixed;
} 