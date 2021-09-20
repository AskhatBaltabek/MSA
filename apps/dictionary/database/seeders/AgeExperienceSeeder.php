<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgeExperience;

class AgeExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title'   => 'менее 25 лет/стаж вождения менее 2 лет',
                'esbd_id' => 1
            ],
            [
                'title'   => 'менее 25 лет/стаж вождения более 2 лет',
                'esbd_id' => 2
            ],
            [
                'title'   => 'старше 25 лет/стаж вождения менее 2 лет',
                'esbd_id' => 3
            ],
            [
                'title'   => 'старше 25 лет/стаж вождения более 2 лет',
                'esbd_id' => 4
            ],
        ];

        foreach ($data as $item) {
            AgeExperience::create([
                'title'   => $item['title'],
                'esbd_id' => $item['esbd_id']
            ]);
        }
    }
}
