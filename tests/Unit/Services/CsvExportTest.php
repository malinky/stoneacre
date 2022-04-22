<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use League\Csv\Writer;
use App\Services\CsvExport;
use Illuminate\Support\Collection;

class CsvExportTest extends TestCase
{
    public function test_it_creates_a_csv()
    {
        $csvExport = app(CsvExport::class);

        $csv = $csvExport->execute('path', new Collection, []);

        $this->assertInstanceOf(Writer::class, $csv);
    }
}
