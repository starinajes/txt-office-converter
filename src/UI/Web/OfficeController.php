<?php

namespace App\UI\Web;

use App\Application\Command\ConvertFileCommand;
use App\Application\Command\ConvertFileHandler;
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

        $handler = new ConvertFileHandler(
            new ParserFactory(),
            new FormatterFactory()
        );

        $command = new ConvertFileCommand($sourcePath, $format);
        $resultDTO = $handler->handle($command);

        return [
            'message' => "Файл '$resultDTO->inputFile' сконвертирован в формат '$resultDTO->format'.",
            'output' => $resultDTO->outputFile,
        ];
    }
} 