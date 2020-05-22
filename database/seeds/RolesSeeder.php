<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>  'Administrador',
            'label'=>  'Administrador'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Diretoria',
            'label'=>  'Diretoria'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Gestor de analista',
            'label'=>  'Gestor de analista'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Analista Senior',
            'label'=>  'Analista Senior'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Analista pleno',
            'label'=>  'Analista pleno'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Cliente',
            'label'=>  'Cliente'
        ]);


    }
}
