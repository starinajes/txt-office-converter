<?php

namespace OfficeConverter\Command;

use OfficeConverter\Formatter\FormatInterface;

interface CommandInterface {
    /**
     * @return FormatInterface
     */
    public function getFormatter(): FormatInterface;
}