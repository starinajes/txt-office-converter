<?php

namespace OfficeConverter\Command;

use Exception;
use OfficeConverter\Formatter\FormatterFactory;
use OfficeConverter\Controller\OfficeConverter;
use OfficeConverter\Parser\ParserFactory;

class ConvertCommand implements CommandInterface
{
    /**
     * @throws Exception
     */
    public static function fromArgs(array $args): ConvertCommandConfig
    {
        $sourcePath = $args[0] ?? null;
        $to         = $args[1] ?? '';

        if (!$sourcePath || !str_starts_with($to, 'to:')) {
            throw new Exception("Использование: convert <файл> to:<формат>");
        }

        $format = substr($to, 3);

        return new ConvertCommandConfig($sourcePath, $format);
    }

    /**
     * @throws Exception
     */
    public function execute(object $config): string
    {
        if (!$config instanceof ConvertCommandConfig) {
            throw new Exception("Неверный тип конфига");
        }

        $sourcePath = $config->sourcePath;
        $format     = $config->targetFormat;

        $parser    = ParserFactory::createParser($sourcePath);
        $formatter = FormatterFactory::create($format);

        $converter = new OfficeConverter();
        $converter
            ->setSourcePath($sourcePath)
            ->addParser($parser)
            ->addFormatter($formatter)
            ->convert()
            ->saveConvertedDataToFile($sourcePath, $format);

        $outputFile = $converter->getOutPathToResult();

        return "Файл '$sourcePath' успешно сконвертирован в формат '$format'.\nРезультат сохранён: $outputFile\n";
    }
} 