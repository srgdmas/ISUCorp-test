<?php

namespace Database\Factories;

use App\Models\Reservations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReservationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservations::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'birth_day' => $this->faker->time('Y-m-d', 'now'),
            'contact_type_id' => 1,
        ];
    }
}
