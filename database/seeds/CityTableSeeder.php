<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'id'=>1,
            'city_name' => 'Bogota',
            'departament_id'=>1,
            'status' => 1,
        ]);

        DB::table('cities')->insert([
            'id'=>2,
            'city_name' => 'Medellin',
            'departament_id'=>2,
            'status' => 1,
        ]);

        DB::table('cities')->insert([
            'id'=>3,
            'city_name' => 'Cali',
            'departament_id'=>3,
            'status' => 1,
        ]);


    }
}
