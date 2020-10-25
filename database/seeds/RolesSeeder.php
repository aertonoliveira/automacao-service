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
            'id' => 1,
            'name'=>  'Administrador',
            'label'=>  'Administrador'
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'name'=>  'Diretoria',
            'label'=>  'Diretoria'
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'name'=>  'Gestor de analista',
            'label'=>  'Gestor de analista'
        ]);
        DB::table('roles')->insert([
            'id' => 4,
            'name'=>  'Analista Senior',
            'label'=>  'Analista Senior'
        ]);
        DB::table('roles')->insert([
            'id' => 5,
            'name'=>  'Analista pleno',
            'label'=>  'Analista pleno'
        ]);
        DB::table('roles')->insert([
            'id' => 6,
            'name'=>  'Cliente',
            'label'=>  'Cliente'
        ]);
        DB::table('roles')->insert([
            'id' => 7,
            'name'=>  'Parceiro',
            'label'=>  'Parceiro'
        ]);
        DB::table('roles')->insert([
            'id' => 8,
            'name'=>  'Tarder',
            'label'=>  'Tarder'
        ]);




    }
}
