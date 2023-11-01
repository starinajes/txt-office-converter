<?php

namespace OfficeConverter\Command;

use Exception;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Formatter\XmlFormat;

/**
 * Команда запуска конвертирования для XML файлов
 */
class XmlConvertCommand implements CommandInterface {
    public function execute(string $sourcePath) {
        $converter = new OfficeConverter();
        $converter->addFormat(new XmlFormat());

        try {
            $outputPath = $converter->convert($sourcePath, 'xml');
            echo "XML Conversion successful. Output file: $outputPath\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
