<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create(
            [
                'ident' => 'ROLE_SUPER_ADMIN',
                'nombre' => 'Super Admin',
            ]
        );
        Role::create(
            [
                'ident' => 'ROLE_ADMIN',
                'nombre' => 'Admin',
            ]
        );
        Role::create(
            [
                'ident' => 'ROLE_USER',
                'nombre' => 'User',
            ]
        );
    }
}
