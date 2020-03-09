<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Administrador del sistema',
            'status' => 1,
        ]);
        DB::table('roles')->insert([
            'name' => 'User',
            'description' => 'Usuario general',
            'status' => 1,
        ]);
    }
}
