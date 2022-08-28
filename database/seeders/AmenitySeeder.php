<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Amenity::insert([
            ['name' => 'Free Wi-Fi'],
            ['name' => 'Room Service'],
            ['name' => 'Suana'],
            ['name' => 'Bar'],
            ['name' => 'Restaurant'],
            ['name' => 'Garden']
        ]);
    }
}
