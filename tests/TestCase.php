<?php

namespace Tests;

use Carbon\Carbon;
use Faker\Generator;
use League\Csv\Writer;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public string $path;

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->path = 'csv/test-csv-for-import.csv';

        $this->faker = Container::getInstance()->make(Generator::class);
    }

    public function createTestCsv(array $headers, array $rows)
    {
        Storage::disk('public')->put($this->path, '');

        $csv = Writer::createFromPath(Storage::disk('public')->path($this->path));

        $csv->insertAll(
            [
                $headers,
                ...array_values(array_map(function($row) {
                    return array_values($row);
                }, $rows))
            ]
        );
    }

    public function deleteTestCsv()
    {
        Storage::disk('public')->delete($this->path);
    }

    public function csvHeaders(): array
    {
        return [
            'REG',
            'MAKE',
            'RANGE',
            'MODEL',
            'DERIVATIVE',
            'PRICE_INC_VAT',
            'COLOUR',
            'MILEAGE',
            'VEHICLE_TYPE',
            'DATE_ON_FORECOURT',
            'IMAGES',
        ];
    }

    public function csvCar(): array
    {
        return [
            'REG' => strtoupper($this->faker->bothify('??##???')),
            'MAKE' => ucwords($this->faker->word()),
            'RANGE' => ucwords($this->faker->words(2, true)),
            'MODEL' => ucwords($this->faker->word()),
            'DERIVATIVE' => ucwords($this->faker->words(4, true)),
            'PRICE_INC_VAT' => number_format($this->faker->numberBetween(1000, 10000), 2),
            'COLOUR' => strtoupper($this->faker->word()),
            'MILEAGE' => $this->faker->numberBetween(1000, 100000),
            'VEHICLE_TYPE' => ucwords($this->faker->word()),
            'DATE_ON_FORECOURT' => Carbon::yesterday()->format('Y-m-d'),
            'IMAGES' => implode(',', $this->faker->words(3)),
        ];
    }

    public function csvCarNoRegistration(): array
    {
        return array_merge(
            $this->csvCar(),
            ['REG' => ''],
        );
    }

    public function csvCarZeroPrice(): array
    {
        return array_merge(
            $this->csvCar(),
            ['PRICE_INC_VAT' => 0],
        );
    }

    public function csvCarLessThanThreeImages(): array
    {
        return array_merge(
            $this->csvCar(),
            ['IMAGES' => implode(',', $this->faker->words(2))],
        );
    }
}
