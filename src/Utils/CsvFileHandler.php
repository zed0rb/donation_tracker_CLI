<?php

namespace App\Utils;

readonly class CsvFileHandler
{
    public function __construct(private string $filePath)
    {
    }

    public function loadData(bool $skipHeader = true): array
    {
        $data = [];

        if (!file_exists($this->filePath)) {
            return $data;
        }

        if (($file = fopen($this->filePath, 'r')) !== false) {
            if ($skipHeader) {
                fgetcsv($file); // Skip the header row
            }

            while (($row = fgetcsv($file)) !== false) {
                $data[] = $row;
            }
            fclose($file);
        }

        return $data;
    }

    public function saveData(array $data, array $header = null): void
    {
        if (($file = fopen($this->filePath, 'w')) !== false) {
            if ($header !== null) {
                fputcsv($file, $header);
            }

            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }
    }
}
