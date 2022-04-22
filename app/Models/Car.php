<?php

namespace App\Models;

use App\Models\Make;
use App\Models\Colour;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    public $guarded = [];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function colour()
    {
        return $this->belongsTo(Colour::class);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
        );
    }

    protected function mileage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value),
        );
    }

    protected function images(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unserialize($value),
            set: fn ($value) => serialize($value),
        );
    }
}
