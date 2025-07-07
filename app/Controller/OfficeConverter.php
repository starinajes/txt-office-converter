<?php

namespace OfficeConverter\Controller;

use Exception;
use OfficeConverter\Formatter\FormatInterface;
use SplFileObject;
use OfficeConverter\Formatter\FormatType;

/**
 * Контроллер конвертации
 */
class OfficeConverter
{
    private string $convertedData = '';
    private string $outPathToResult = '';

    /**
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
     * Метод запуска конвертации
     * @param  string  $sourcePath
     * @param  FormatType  $format
     *
     * @throws Exception
     */
    public function convert(string $sourcePath, FormatType $format): void
    {
        $dataIterator = $this->readFromFile(STORAGE_DIR_PATH.$sourcePath);
        $formatInstance = $this->getFormat($format);

        if (!$formatInstance) {
            throw new Exception('Missed format');
        }

        $this->convertedData = $formatInstance->convert($dataIterator);
    }

    /**
     * Метод чтения файла
     *
     * @param  string  $sourcePath
     *
     * @return SplFileObject
     * @throws Exception
     */
    private function readFromFile(string $sourcePath): SplFileObject
    {
        if (!file_exists($sourcePath)) {
            throw new Exception("File not found: $sourcePath");
        }

        return new SplFileObject($sourcePath);
    }

    /**
     * Метод сохранения спарсенных данных в файл.
     * Поддерживает вложенность
     * @param string $sourcePath
     * @param string $fileType
     * @throws Exception
     */
    public function saveConvertedDataToFile(string $sourcePath, string $fileType): void
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $newPath   = str_replace(".$extension", ".$fileType", $sourcePath);
        $fileName  = OUTPUT_DIR_PATH.$newPath;

        $directory = dirname($fileName);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        try {
            file_put_contents( $fileName, $this->convertedData);
        } catch (Exception $exception) {
            throw new Exception("Error: failed to save file - " . $exception->getMessage());
        }

        $this->outPathToResult = $fileName;
    }

    /**
     * Метод возвращает конечный путь до созданного файла
     * @return string
     */
    public function getOutPathToResult(): string
    {
        return $this->outPathToResult;
    }

    /**
     * Получить нужный формат
     *
     * @param  FormatType  $format
     *
     * @return FormatInterface|null
     * @throws Exception
     */
    private function getFormat(FormatType $format): ?FormatInterface
    {
        foreach ($this->formats as $formatInstance) {
            if ($formatInstance->getTypeFormat() === $format) {
                return $formatInstance;
            }
        }

        throw new Exception("Unsupported format: $format->value");
    }

    /**
     * Преобразовать строку в FormatType
     * @param string $format
     * @return FormatType
     * @throws Exception
     */
    public static function formatTypeFromString(string $format): FormatType
    {
        return match(strtolower($format)) {
            'json' => FormatType::JSON,
            'xml' => FormatType::XML,
            default => throw new Exception("Unknown format: $format"),
        };
    }
}