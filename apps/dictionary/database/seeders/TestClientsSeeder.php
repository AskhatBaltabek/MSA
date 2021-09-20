<?php

namespace Database\Seeders;

use App\Models\TestClients;
use Illuminate\Database\Seeder;

class TestClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestClients::truncate();

        $clients = [
            [
                'client_id' => 32941413,
                'iin' => 930421400841,
                'first_name' => 'МАРАЛ',
                'middle_name' => '',
                'last_name' => 'КУЛЖАБАЕВА',
                'natural_person_bool' => 1,
                'class_id' => 1,
                'born' => '1993.04.21',
                'sex_id' => 2,
                'resident_bool' => 1,
                'bonus_malus' => 'M',
                'document_number' => '040110089',
                'document_gived_date' => '2016.05.16',
                'document_type_id' => 1,
                'age_experience_id' => 1,
                'priveleger_bool' => 0,
                'email' => 'maraltesttest@a-i.kz',
                'phone' => 70001112233
            ]
        ];

        TestClients::insert($clients);
    }
}
