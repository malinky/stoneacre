<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    public $guarded = [];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
