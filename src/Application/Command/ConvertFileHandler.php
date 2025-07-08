<?php

namespace App\Application\Command;

use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Formatter\FormatterFactory;
use App\Application\Command\DTO\ConvertResultDTO;
use App\Infrastructure\Config\Paths;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

readonly class ConvertFileHandler implements CommandInterface
{
    public function __construct(
        private ParserFactory          $parserFactory,
        private FormatterFactory       $formatterFactory
    ) {}

    /**
     * @throws Exception
     */
    public static function fromArgs(array $args): object
    {
        $type = null;
        // Поддержка --type=car или --type=office
        if (isset($args[0]) && str_starts_with($args[0], '--type=')) {
            $type = substr($args[0], 7);
            array_shift($args);
        }

        $sourcePath = $args[0] ?? null;
        $to         = $args[1] ?? '';

        if (!$sourcePath || !str_starts_with($to, 'to:')) {
            throw new Exception("Использование: convert [--type=тип] <файл> to:<формат>");
        }

        $format = substr($to, 3);

        return new ConvertFileCommand($sourcePath, $format, $type);
    }

    /**
     * @throws Exception
     */
    public function execute(ConvertFileCommand $config): string
    {
        $dto = $this->handle($config);
        $relativePath = $this->relativeOutputPath($dto->outputFile);

        return "Файл '$dto->inputFile' сконвертирован в формат '$dto->format'.\nРезультат: $relativePath\n";
    }

    /**
     * @throws Exception
     */
    public function handle(ConvertFileCommand $command): ConvertResultDTO
    {
        $filePath = $this->resolveFilePath($command->sourcePath);
        $parser = $this->parserFactory->create($filePath, $command->type);
        $entities = $parser->parse($filePath);
        $formatter = $this->formatterFactory->create($command->format);
        $result = $formatter->format($entities);
        $outputFile = $this->saveResult($filePath, $command->format, $result);

        return new ConvertResultDTO($filePath, $outputFile, $command->format);
    }

    /**
     * @throws Exception
     */
    private function resolveFilePath(string $fileName): string
    {
        if (str_contains($fileName, '/')) {
            return $fileName;
        }

        $storagePath = Paths::getStoragePath();
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath)
        );

        foreach ($files as $file) {
            if ($file->isFile() && $file->getFilename() === $fileName) {
                return $file->getPathname();
            }
        }

        throw new Exception("Файл '$fileName' не найден в storage/");
    }

    private function saveResult(string $sourcePath, string $format, string $data): string
    {
        $storagePath = realpath(Paths::getStoragePath());
        $absSource = realpath($sourcePath);

        // Получаем относительный путь файла относительно storage
        $relative = $absSource && $storagePath && str_starts_with($absSource, $storagePath)
            ? ltrim(substr($absSource, strlen($storagePath)), '/\\')
            : basename($sourcePath);

        // Меняем расширение
        $relative = preg_replace('/\.[^.]+$/', ".$format", $relative);

        $outputFile = rtrim(Paths::getOutputPath(), '/\\') . '/' . $relative;

        // Создаём директорию, если её нет
        $dir = dirname($outputFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($outputFile, $data);

        return $outputFile;
    }

    private function relativeOutputPath(string $absolutePath): string
    {
        $outputDir = realpath(Paths::getOutputPath());
        $abs = realpath($absolutePath);

        if ($outputDir && $abs && str_starts_with($abs, $outputDir)) {
            return 'output/' . ltrim(substr($abs, strlen($outputDir)), '/\\');
        }

        return $absolutePath;
    }
} 