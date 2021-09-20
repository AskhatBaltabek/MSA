<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::truncate();

        $options = [
            [
                'id' => 1,
                'program_id' => 4,
                'title' => 'СТО Автосалона',
            ],
            [
                'id' => 2,
                'program_id' => 4,
                'title' => 'Без спец.СТО',
            ],
            [
                'id' => 3,
                'program_id' => 4,
                'title' => 'По отчету оценщика',
            ]
        ];

        Option::insert($options);
    }
}
