<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ReadFromCsv;
use Illuminate\Support\Collection;

class ReadFromCsvTest extends TestCase
{
    protected array $car;

    protected function setUp(): void
    {
        parent::setUp();

        $this->car = $this->csvCar();
    }

    public function test_it_reads_from_a_csv()
    {
        $this->createTestCsv($this->csvHeaders(), [$this->car]);

        $service = app(ReadFromCsv::class);

        $records = $service->execute($this->path);

        $this->assertInstanceOf(Collection::class, $records);

        $this->assertCount(1, $records);

        $this->assertEquals(
            $records->first(),
            $this->car,
        );

        $this->deleteTestCsv();
    }
}
