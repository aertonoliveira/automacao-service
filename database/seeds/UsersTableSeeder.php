<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('1234'),
            'ativo'             => true,
            'role_id'             => 1,

        ]);


        User::create([
            'name'              => 'John Doe',
            'email'             => 'user@user.com',
            'password'          => Hash::make('1234'),
            'ativo'             => true,
            'role_id'             => 2,
        ]);

        DB::table('role_user')->insert([
            'user_id' =>  1,
            'role_id' =>  1
        ]);

    }
}
