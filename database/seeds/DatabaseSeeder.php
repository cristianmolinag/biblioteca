<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::table('usuario')->insert([
          'nombres' => 'Administrador',
          'apellidos' => 'Del Sistema',
          'documento' => '1234',
          'correo' => 'admin@udc.com',
          'password' => bcrypt('secret'),
          'tipo_usuario' => 'Administrador'
      ]);

      DB::table('ubicacion')->insert([
        'nombre' => 'Baja'
      ]);
    }
}
