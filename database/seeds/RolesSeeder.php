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
            'name'=>  'Adm',
            'label'=>  'Administrador'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Gerente',
            'label'=>  'Gerente'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Promotor',
            'label'=>  'Promotor'
        ]);
        DB::table('roles')->insert([
            'name'=>  'Cliente',
            'label'=>  'Cliente'
        ]);
    }
}
