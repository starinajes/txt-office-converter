<?php

namespace OfficeConverter\Controller;

use Exception;
use OfficeConverter\Formatter\FormatInterface;
use SplFileObject;
use OfficeConverter\Parser\ParserInterface;
use OfficeConverter\Parser\ParserFactory;

/**
 * Контроллер конвертации
 */
class OfficeConverter
{
    private string $convertedData = '';
    private string $outPathToResult = '';
    private ?ParserInterface $parser = null;
    private ?FormatInterface $formatter = null;
    private ?string $sourcePath = null;

    public function setSourcePath(string $sourcePath): self
    {
        $this->sourcePath = $sourcePath;
        return $this;
    }

    public function addParser(ParserInterface $parser): self
    {
        $this->parser = $parser;
        return $this;
    }

    public function addFormatter(FormatInterface $formatter): self
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * Метод запуска конвертации
     * @return OfficeConverter
     * @throws Exception
     */
    public function convert(): self
    {
        if (!$this->sourcePath) {
            throw new Exception('Source path not set');
        }

        if (!$this->parser) {
            $this->parser = ParserFactory::createParser($this->sourcePath);
        }

        if (!$this->formatter) {
            throw new Exception('Formatter not set');
        }

        $dataIterator = $this->readFromFile(STORAGE_DIR_PATH . $this->sourcePath);
        $parsedData = $this->parser->parse($dataIterator);

        $this->convertedData = $this->formatter->format($parsedData);

        return $this;
    }

    /**
     * @throws Exception
     */
    private function readFromFile(string $sourcePath): SplFileObject
    {
        if (!file_exists($sourcePath)) {
            throw new Exception("Файл не найден: $sourcePath");
        }

        return new SplFileObject($sourcePath);
    }

    /**
     * @throws Exception
     */
    public function saveConvertedDataToFile(string $sourcePath, string $fileType): self
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $newPath   = str_replace(".$extension", ".$fileType", $sourcePath);
        $fileName  = OUTPUT_DIR_PATH . $newPath;

        $directory = dirname($fileName);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        try {
            file_put_contents($fileName, $this->convertedData);
        } catch (Exception $exception) {
            throw new Exception("Ошибка: не удалось сохранить файл - " . $exception->getMessage());
        }

        $this->outPathToResult = $fileName;

        return $this;
    }

    public function getOutPathToResult(): string
    {
        return $this->outPathToResult;
    }
}