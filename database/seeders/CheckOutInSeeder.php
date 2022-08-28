<?php

namespace Database\Seeders;

use App\Models\CheckIn;
use App\Models\CheckOut;
use Illuminate\Database\Seeder;

class CheckOutInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckIn::insert([
            [

                'from' => '12:00',
                'to' => '13:00'
            ],
            [

                'from' => '13:00',
                'to' => '13:00'
            ],
            [

                'from' => '14:00',
                'to' => '13:00'
            ],


        ]);


        CheckOut::insert([
            [

                'from' => '12:00',
                'to' => '13:00'
            ],
            [

                'from' => '13:00',
                'to' => '13:00'
            ],
            [

                'from' => '14:00',
                'to' => '13:00'
            ],
        ]);
    }
}
