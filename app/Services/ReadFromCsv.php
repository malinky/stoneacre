<?php

namespace App\Services;

use League\Csv\Reader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ReadFromCsv
{
    public function execute(string $path): Collection
    {
        $csv = Reader::createFromPath(Storage::disk('public')->path($path));
        $csv->setHeaderOffset(0);

        return collect($csv->getRecords())->values();
    }
}
