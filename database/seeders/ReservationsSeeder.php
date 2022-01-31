<?php

namespace Database\Seeders;

use App\Models\Reservations;
use Database\Factories\ReservationsFactory;
use Illuminate\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservations::newFactory()->count(150)->create();
    }
}
