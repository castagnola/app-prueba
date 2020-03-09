<?php

use Illuminate\Database\Seeder;

class TipeVehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_vehicle')->insert([
            'id'=>1,
            'description' => 'Particular',
            'status' => 1,
        ]);

        DB::table('tipe_vehicle')->insert([
            'id'=>2,
            'description' => 'Publico',
            'status' => 1,
        ]);
    }
}
