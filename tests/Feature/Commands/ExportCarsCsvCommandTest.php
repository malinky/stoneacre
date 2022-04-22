<?php

namespace Tests\Feature\Commands;

use Carbon\Carbon;
use App\Models\Car;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportCarsCsvCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_exports_a_csv()
    {
        Carbon::setTestNow(Carbon::createFromDate(2022, 3, 2)->startOfDay());

        Storage::fake('public');

        $car = Car::factory()->create();

        $this->artisan('stoneacre:export-cars-csv '.$car->make->make)->assertSuccessful();

        Storage::disk('public')->assertExists('csv/2022-03-02 000000.csv');
    }
}
