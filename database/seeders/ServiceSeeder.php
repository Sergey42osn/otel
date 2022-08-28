<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert(
            [
                ['name' => 'Free Wi-Fi'],
                ['name' => 'Room Service'],
                ['name' => 'Suana'],
                ['name' => 'Bar'],
                ['name' => 'Restaurant'],
                ['name' => 'Garden']
            ]
        );
    }
}
