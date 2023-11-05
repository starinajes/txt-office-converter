<?php

namespace OfficeConverter\Formatter;

use Exception;
use OfficeConverter\Parser\TxtParser;

abstract class FormatBase implements FormatInterface
{
    /**
     * Метод конвертации
     * @throws Exception
     */
    public function convert($data): string
    {
        $parsedData = (new TxtParser())->parse($data);

        return $this->parse($parsedData);
    }

    /**
     * Метод проверки поддержки формата
     * @param  string  $format
     *
     * @return bool
     */
    public function isSupportFormat(string $format): bool
    {
        return $format === $this->getTypeFormat();
    }
}