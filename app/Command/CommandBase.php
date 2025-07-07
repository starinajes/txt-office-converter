<?php

namespace OfficeConverter\Command;

use Exception;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\FormatType;

/**
 * Базовый класс cli команд
 */
abstract class CommandBase implements CommandInterface
{
    protected OfficeConverter $converter;

    public function __construct(OfficeConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Метод запуска команды
     *
     * @param  string  $sourcePath
     * @param  FormatType  $formatType
     *
     * @return string Путь к результату
     * @throws Exception
     */
    public function execute(string $sourcePath, FormatType $formatType): string
    {
        $formatter = $this->getFormatter();
        $this->converter->addFormat($formatter);

        $this->converter->convert($sourcePath, $formatType);
        $this->converter->saveConvertedDataToFile($sourcePath, $formatType->value);

        return $this->converter->getOutPathToResult();
    }
}