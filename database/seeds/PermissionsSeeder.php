<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'=>  'MODULO_CADASTRO_CLIENTE',
        ]);
        DB::table('permissions')->insert([
            'name'=>  'MODULO_PERMISSAO',
        ]);
        DB::table('permissions')->insert([
            'name'=>  'MODULO_ADMINISTRACAO',
        ]);
    }
}
