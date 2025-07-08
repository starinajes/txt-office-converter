<?php

namespace App\UI\Web;

use App\Application\Command\ConvertOfficeFileCommand;
use App\Application\Command\ConvertOfficeFileHandler;
use App\Domain\Office\Service\OfficeConverterService;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;
use Exception;

class OfficeController
{
    /**
     * @param array $request ['file' => путь к файлу, 'format' => формат]
     * @return array
     * @throws Exception
     */
    public function convertAction(array $request): array
    {
        $sourcePath = $request['file'];
        $format = $request['format'];

        $handler = new ConvertOfficeFileHandler(
            new OfficeConverterService(),
            new ParserFactory(),
            new FormatterFactory()
        );

        $command = new ConvertOfficeFileCommand($sourcePath, $format);
        $resultDTO = $handler->handle($command);

        return [
            'message' => "Файл '$resultDTO->inputFile' сконвертирован в формат '$resultDTO->format'.",
            'output' => $resultDTO->outputFile,
        ];
    }
} 