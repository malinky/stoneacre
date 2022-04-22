<?php

namespace Tests\Feature\Actions;

use App\Models\Car;
use Tests\TestCase;
use App\Services\CsvImportReport;
use App\Actions\ImportCarsCsvAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportCarsCsvActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_imports_a_csv()
    {
        $this->createTestCsv($this->csvHeaders(), [$this->csvCar()]);

        $action = app(ImportCarsCsvAction::class);

        $report = $action->execute($this->path);

        $this->assertCount(1, Car::all());

        $this->assertInstanceOf(CsvImportReport::class, $report);

        $this->deleteTestCsv();
    }

    public function test_registration_is_required()
    {
        $this->createTestCsv($this->csvHeaders(), [$this->csvCarNoRegistration()]);

        $action = app(ImportCarsCsvAction::class);

        $report = $action->execute($this->path);

        $this->assertCount(1, $report->getFailed());

        $this->deleteTestCsv();
    }

    public function test_price_is_greater_than_zero()
    {
        $this->createTestCsv($this->csvHeaders(), [$this->csvCarZeroPrice()]);

        $action = app(ImportCarsCsvAction::class);

        $report = $action->execute($this->path);

        $this->assertCount(1, $report->getFailed());

        $this->deleteTestCsv();
    }

    public function test_atleast_three_images()
    {
        $this->createTestCsv($this->csvHeaders(), [$this->csvCarLessThanThreeImages()]);

        $action = app(ImportCarsCsvAction::class);

        $report = $action->execute($this->path);

        $this->assertCount(1, $report->getFailed());

        $this->deleteTestCsv();
    }
}
