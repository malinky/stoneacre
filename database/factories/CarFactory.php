<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Make;
use App\Models\Colour;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'make_id' => Make::factory(),
            'vehicle_type_id' => VehicleType::factory(),
            'colour_id' => Colour::factory(),
            'registration' => strtoupper($this->faker->bothify('??##???')),
            'range' => ucwords($this->faker->words(2, true)),
            'model' => ucwords($this->faker->word()),
            'derivative' => ucwords($this->faker->words(4, true)),
            'price' => $this->faker->numberBetween(1000, 10000),
            'mileage' => $this->faker->numberBetween(1000, 100000),
            'images' => $this->faker->words(3),
            'active' => true,
            'date_on_forecourt' => Carbon::yesterday(),
        ];
    }
}
