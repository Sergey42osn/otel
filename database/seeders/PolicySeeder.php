<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Policy::insert([
            [
                'type' => 'payable',
                'name' => 'From the full cost of living'
            ],
            [
                'type' => 'payable',
                'name' => 'On the previous of arrival'
            ],
            [
                'type' => 'not_payable',
                'name' => 'On the day of arrival (18:00)'
            ],
            [
                'type' => 'not_payable',
                'name' => 'On the previous of arrival (18:00)'
            ]
        ]);
    }
}
