<?php

namespace OfficeConverter\Formatter;

use Exception;
use OfficeConverter\Parser\ParserInterface;
use SplFileObject;

abstract class FormatBase implements FormatInterface
{
    protected ParserInterface $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Метод конвертации
     * @throws Exception
     */
    public function convert(SplFileObject $data): string
    {
        $parsedData = $this->parser->parse($data);

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
        return $format == $this->getTypeFormat();
    }
}