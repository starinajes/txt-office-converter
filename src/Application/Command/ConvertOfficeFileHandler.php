<?php

namespace App\Application\Command;

use App\Domain\Office\Service\OfficeConverterService;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;
use App\Application\Command\DTO\ConvertResultDTO;
use App\Infrastructure\Config\Paths;
use Exception;

readonly class ConvertOfficeFileHandler implements CommandInterface
{
    public function __construct(
        private OfficeConverterService $service,
        private ParserFactory          $parserFactory,
        private FormatterFactory       $formatterFactory
    ) {}

    /**
     * @throws Exception
     */
    public static function fromArgs(array $args): object
    {
        $sourcePath = $args[0] ?? null;
        $to         = $args[1] ?? '';

        if (!$sourcePath || !str_starts_with($to, 'to:')) {
            throw new Exception("Использование: convert <файл> to:<формат>");
        }

        $format = substr($to, 3);

        return new ConvertOfficeFileCommand($sourcePath, $format);
    }

    /**
     * @throws Exception
     */
    public function execute(ConvertOfficeFileCommand $config): string
    {
        $dto = $this->handle($config);
        $relativePath = $this->relativeOutputPath($dto->outputFile);

        return "Файл '$dto->inputFile' сконвертирован в формат '$dto->format'.\nРезультат: $relativePath\n";
    }

    /**
     * @throws Exception
     */
    public function handle(ConvertOfficeFileCommand $command): ConvertResultDTO
    {
        $parser = $this->parserFactory->create($command->sourcePath);
        $formatter = $this->formatterFactory->create($command->format);
        $result = $this->service->convert($command->sourcePath, $parser, $formatter);
        $outputFile = $this->saveResult($command->sourcePath, $command->format, $result);

        return new ConvertResultDTO($command->sourcePath, $outputFile, $command->format);
    }

    private function saveResult(string $sourcePath, string $format, string $data): string
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $newPath = str_replace(".$extension", ".$format", $sourcePath);
        $outputFile = Paths::OUTPUT . $newPath;
        file_put_contents($outputFile, $data);

        return $outputFile;
    }

    private function relativeOutputPath(string $absolutePath): string
    {
        $outputDir = realpath(Paths::OUTPUT);
        $abs = realpath($absolutePath);

        if ($outputDir && $abs && str_starts_with($abs, $outputDir)) {
            return 'output/' . ltrim(substr($abs, strlen($outputDir)), '/\\');
        }

        return $absolutePath;
    }
} 