<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::insert([
            [
                'name' => 'Hotel',
                'type' => 'Hotel'
            ],
            [
                'name' => 'Motel',
                'type' => 'Hotel'
            ],
            [
                'name' => 'Motel',
                'type' => 'Hotel'
            ]
        ]);
    }
}
