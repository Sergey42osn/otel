<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnerShip;

class PartnerShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerShip::insert([
            [
                'code' => 'super_user',
                'personal_information' => 1,
                'security' => 1,
                'booking_and_reports' => 1,
                'reviews' => 1,
                'my_objects' => 1,
                'finance_documents' => 1,
                'partners' => 1
            ],
            [
                'code' => 'front_office',
                'personal_information' => 1,
                'security' => 0,
                'booking_and_reports' => 1,
                'reviews' => 1,
                'my_objects' => 0,
                'finance_documents' => 0,
                'partners' => 0
            ],
            [
                'code' => 'reservation_department',
                'personal_information' => 1,
                'security' => 0,
                'booking_and_reports' => 1,
                'reviews' => 1,
                'my_objects' => 1,
                'finance_documents' => 1,
                'partners' => 0
            ],
            [
                'code' => 'accounting',
                'personal_information' => 1,
                'security' => 0,
                'booking_and_reports' => 1,
                'reviews' => 0,
                'my_objects' => 0,
                'finance_documents' => 1,
                'partners' => 0
            ],
        ]);
    }
}
