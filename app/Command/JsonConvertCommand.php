<?php

namespace OfficeConverter\Command;

use Exception;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\JsonFormat;

/**
 * Команда запуска конвертирования для JSON файлов
 */
class JsonConvertCommand implements CommandInterface {
    public function execute(string $sourcePath) {
        $converter = new OfficeConverter();
        $converter->addFormat(new JsonFormat());

        try {
            $outputPath = $converter->convert($sourcePath, 'json');
            echo "JSON Conversion successful. Output file: $outputPath";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}