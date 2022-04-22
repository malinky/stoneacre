<?php

namespace Tests\Feature\Actions;

use Carbon\Carbon;
use App\Models\Car;
use Tests\TestCase;
use League\Csv\Reader;
use App\Actions\ExportCarsCsvAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportCarsCsvActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_exports_an_application_csv()
    {
        Carbon::setTestNow(Carbon::createFromDate(2022, 3, 2)->startOfDay());

        Storage::fake('public');

        $car = Car::factory()->create();

        $action = app(ExportCarsCsvAction::class);

        $path = $action->execute($car->make->make);

        // Returned response assertion.
        $this->assertEquals('csv/2022-03-02 000000.csv', $path);

        // File exists assertion.
        Storage::disk('public')->assertExists($path);

        $csv = Reader::createFromPath(Storage::disk('public')->path($path));

        // Csv data assertion.
        $this->assertEquals(
            [
                $car->registration,
                $car->make->make.' '.$car->model.' '.$car->derivative,
                number_format($car->price / 1.2, 2),
                number_format($car->price - ($car->price / 1.2), 2),
                $car->images[0],
            ],
            $csv->fetchOne(1)
        );

        // Csv count assertion (includes header row).
        $this->assertCount(2, $csv);

        // Csv header assertion.
        $csv->setHeaderOffset(0);
        $this->assertEquals([
            'Registration',
            'Car Title',
            'Price',
            'VAT',
            'Image',
        ], $csv->getHeader());
    }
}
