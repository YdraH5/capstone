<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('apartment')->insert([
            'category_id' => '',
            'room_number' => '',
            'renter_id' => '',
            'building_id'=>'',
            'status'=>'',
        ]);
    }
}
