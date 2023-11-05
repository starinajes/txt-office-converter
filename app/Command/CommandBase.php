<?php

namespace OfficeConverter\Command;

use Exception;
use OfficeConverter\Controller\OfficeConverter;

/**
 * Базовый класс cli команд
 */
abstract class CommandBase implements CommandInterface
{
    /**
     * Метод запуска команды
     *
     * @param  string  $sourcePath
     *
     * @throws Exception
     */
    public function execute(string $sourcePath): void
    {
        $formatter = $this->getFormatterClass();

        $converter = new OfficeConverter();
        $converter->addFormat($formatter);

        try {
            $converter->convert($sourcePath, $formatter->getTypeFormat());
            $converter->saveConvertedDataToFile($sourcePath, $formatter->getTypeFormat());
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }

        echo "Conversion successful. Output file: " . $converter->getOutPathToResult() . PHP_EOL;
    }
}