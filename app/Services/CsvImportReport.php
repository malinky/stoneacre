<?php

namespace App\Services;

class CsvImportReport
{
    public int $imported = 0;

    public array $failed = [];

    public function successful()
    {
        $this->imported++;
    }

    public function failed(int $row, string $error)
    {
        $this->failed[] = [
            $row,
            $error,
        ];
    }

    public function getImported(): int
    {
        return $this->imported;
    }

    public function getFailed(): array
    {
        return $this->failed;
    }
}
