<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lang::insert([
            [
                'name' => 'Russian',
                'code' => 23
            ],
            [
                'name' => 'English',
                'code' => 1
            ],
            [
                'name' => 'Armenian',
                'code' => 12
            ],
            [
                'name' => 'Belorussian',
                'code' => 34
            ]
        ]);
    }
}
