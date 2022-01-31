<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\OldsPasswords;
use App\Models\User;
use App\Models\Permisos;
use App\Models\BillingUserConcepts;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
            [
                'name' => 'John',
                'lastname' => 'Doe',
                'email' => 'jdoe@test.test',
                'email_verified_at' => date('Y-m-d G:i:s', time()),
                'last_time_passwors_change' => date('Y-m-d G:i:s', time()),
                'token' => time(),
                'phone' => '00000000000',
                'roles_id' => '1',
                'password' => Hash::make('jdoe1234'),
            ]
        );

        (new \App\Models\Notification)->create('Bienvenido a ISUCorp '.$user->name.' '.$user->lastname,0,$user->id);

        OldsPasswords::create(
            [
                'password' => $user->password,
                'users_id' => $user->id
            ]
        );

    }
}
