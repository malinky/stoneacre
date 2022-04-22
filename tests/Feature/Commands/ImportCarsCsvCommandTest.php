<?php

namespace Tests\Feature\Commands;

use App\Models\Car;
use Tests\TestCase;
use App\Mail\ImportCarsCsvReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportCarsCsvCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_imports_a_csv()
    {
        Mail::fake();

        $this->createTestCsv($this->csvHeaders(), [$this->csvCar()]);

        $this->artisan('stoneacre:import-cars-csv test-csv-for-import.csv')->assertSuccessful();

        $this->assertCount(1, Car::all());

        $this->deleteTestCsv();

        Mail::assertSent(ImportCarsCsvReport::class);
    }
}
