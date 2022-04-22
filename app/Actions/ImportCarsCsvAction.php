<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Make;
use App\Models\Colour;
use App\Models\VehicleType;
use App\Services\ReadFromCsv;
use App\Services\CsvImportReport;
use Illuminate\Support\Facades\Validator;

class ImportCarsCsvAction
{
    public function __construct(
        protected ReadFromCsv $readFromCsv,
        protected CsvImportReport $csvImportReport,
    ) {}

    public function execute(string $path): CsvImportReport
    {
        $this->readFromCsv->execute($path)
            ->each(function (array $row, $rowCount) {
                $data = $this->prepareData($row);

                $validator = Validator::make($data, [
                    'registration' => ['required'],
                    'price' => ['gt:0'],
                    'images' => ['min:3'],
                ]);

                if ($validator->fails()) {
                    $this->csvImportReport->failed(
                        $rowCount+1,
                        $validator->errors()->first(),
                    );
                } else {
                    Car::create($data);

                    $this->csvImportReport->successful();
                }
            });

        return $this->csvImportReport;
    }

    public function prepareData(array $data): array
    {
        return [
            'make_id' => Make::firstOrCreate(['make' => $data['MAKE']])->id,
            'vehicle_type_id' => VehicleType::firstOrCreate(['vehicle_type' => $data['VEHICLE_TYPE']])->id,
            'colour_id' => Colour::firstOrCreate(['colour' => $data['COLOUR']])->id,
            'registration' => $data['REG'],
            'range' => $data['RANGE'],
            'model' => $data['MODEL'],
            'derivative' => $data['DERIVATIVE'],
            'price' => $this->formatPrice($data['PRICE_INC_VAT']),
            'mileage' => $data['MILEAGE'],
            'images' => explode(',', $data['IMAGES']),
            'active' => $this->isActive($data['DATE_ON_FORECOURT']),
            'date_on_forecourt' => $this->formatDate($data['DATE_ON_FORECOURT']),
        ];
    }

    protected function formatPrice(string $price): float
    {
        return number_format(str_replace([','], '', $price) * 100, 0, '', '');
    }

    protected function isActive(string $date): bool
    {
        if ($date == '0000-00-00') {
            return false;
        }

        return Carbon::createFromFormat('Y-m-d', $date)->isPast();
    }

    protected function formatDate(string $date): null|Carbon
    {
        if ($date == '0000-00-00') {
            return null;
        }

        return Carbon::createFromFormat('Y-m-d', $date);
    }
}
