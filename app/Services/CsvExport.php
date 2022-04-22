<?php

namespace App\Services;

use League\Csv\Writer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CsvExport
{
    public function execute(string $path, Collection $data, array $headers): Writer
    {
        Storage::disk('public')->put($path, contents: '');

        $csv = Writer::createFromPath(Storage::disk('public')->path($path));

        $csv->insertOne($headers);

        $data->each(function (array $row) use ($csv) {
            $csv->insertOne($row);
        });

        return $csv;
    }
}
