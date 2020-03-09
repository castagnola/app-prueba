<?php

use Illuminate\Database\Seeder;

class DepartamentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departaments')->insert([
            'id' => 1,
            'departament_name' => '	Cundinamarca',
            'status' => 1,
        ]);

        DB::table('departaments')->insert([
            'id' => 2,
            'departament_name' => 'Antioquia',
            'status' => 1,
        ]);

        DB::table('departaments')->insert([
            'id' => 3,
            'departament_name' => '	Valle del Cauca',
            'status' => 1,
        ]);
    }
}
