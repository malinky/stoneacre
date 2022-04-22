<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Make extends Model
{
    use HasFactory;

    public $guarded = [];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
