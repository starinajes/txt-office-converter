<?php

namespace OfficeConverter\Command;

interface CommandInterface {
    public static function fromArgs(array $args): object;
    public function execute(object $config): mixed;
}