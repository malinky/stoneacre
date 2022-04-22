<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Car;
use App\Services\CsvExport;

class ExportCarsCsvAction
{
    public function __construct(
        protected CsvExport $csvExport
    ) {}

    public function execute(string $make): string
    {
        $path = 'csv/'.Carbon::now()->toDateString().' '.Carbon::now()->format('His').'.csv';

        $data = Car::query()
            ->whereRelation('make', 'make', $make)
            ->get()
            ->map(function ($car) use ($make) {
                return [
                    $car->registration,
                    $make.' '.$car->model.' '.$car->derivative,
                    number_format($car->price / 1.2, 2),
                    number_format($car->price - ($car->price / 1.2), 2),
                    $car->images[0],
                ];
            });

        $this->csvExport->execute($path, $data, $this->headers());

        return $path;
    }

    protected function headers(): array
    {
        return [
            'Registration',
            'Car Title',
            'Price',
            'VAT',
            'Image',
        ];
    }
}
