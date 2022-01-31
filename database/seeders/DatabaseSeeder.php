<?php

use Database\Seeders\ArcadaTratarSeeder;
use Database\Seeders\CasosSeeder;
use Database\Seeders\CategoriasSeguimientoSeeder;
use Database\Seeders\ClinicaSeeder;
use Database\Seeders\ContactsTypesSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\DatosFacturacionSeeder;
use Database\Seeders\DientesSeeder;
use Database\Seeders\EspecialidadesSeeder;
use Database\Seeders\EstadosProcesosSeeder;
use Database\Seeders\MunicipalitiesSeeder;
use Database\Seeders\PermisosRoleSeeder;
use Database\Seeders\ProblemaSeeder;
use Database\Seeders\ProvincesSeeder;
use Database\Seeders\ReservationsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SeguimientoCasosSeeder;
use Database\Seeders\SolucionesSeeder;
use Database\Seeders\TipoCasosSeeder;
use Database\Seeders\TiposClientesSeeder;
use Database\Seeders\TiposPagosSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ContactsTypesSeeder::class);
        $this->call(ReservationsSeeder::class);
    }
}
