<?php

namespace Database\Seeders;

use App\Models\ContactsTypes;
use Illuminate\Database\Seeder;

class ContactsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactsTypes::create(
            [
                'ident' => 'ct1',
                'label' => 'Contact type 1',
                'name' => 'Contact type 1',
            ]
        );
        ContactsTypes::create(
            [
                'ident' => 'ct2',
                'label' => 'Contact type 2',
                'name' => 'Contact type 2',
            ]
        );
        ContactsTypes::create(
            [
                'ident' => 'ct3',
                'label' => 'Contact type 3',
                'name' => 'Contact type 3',
            ]
        );
    }
}
