<?php

namespace OfficeConverter\Controller;

use Exception;
use OfficeConverter\Formatter\FormatInterface;

/**
 * Контроллер конвертации
 */
class OfficeConverter
{
    /**
     * Форматы
     * @FormatInterface[]
     * @var array
     */
    private array $formats = [];

    /**
     * @param  FormatInterface  $format
     *
     * @return void
     */
    public function addFormat(FormatInterface $format): void
    {
        $this->formats[] = $format;
    }

    /**
     * @param  string  $sourcePath
     * @param  string  $format
     *
     * @return string|null
     * @throws Exception
     */
    public function convert(string $sourcePath, string $format): ?string
    {
        $data = $this->readFromFile($sourcePath);
        $format = $this->getFormat($format);

        if ($format) {
            $outputPath = (new $format())->convert($data);
            return $outputPath;
        }

        return null;
    }

    /**
     * @param  string  $sourcePath
     *
     * @return false|string
     * @throws Exception
     */
    private function readFromFile(string $sourcePath): false|string
    {
        if (file_exists($sourcePath)) {
            return file_get_contents($sourcePath);
        }

        throw new Exception("File not found: $sourcePath");
    }

    /**
     * @param  string  $format
     *
     * @return mixed
     * @throws Exception
     */
    private function getFormat(string $format): mixed
    {
        foreach ($this->formats as $formatInstance) {
            if ($formatInstance->supports($format)) {
                return $formatInstance;
            }
        }

        throw new Exception("Unsupported format: $format");
    }
}