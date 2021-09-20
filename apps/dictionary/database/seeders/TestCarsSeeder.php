<?php

namespace Database\Seeders;

use App\Models\TestCars;
use Illuminate\Database\Seeder;

class TestCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestCars::truncate();

        $cars = [
            [
                'tf_id' => 1786217,
                'type_id' => 4,
                'vin' => 'SXM100002162',
                'reg_num' => '024ZNA05',
                'reg_cert_num' => 'BQ00124775',
                'dt_reg_cert' => '2016.08.23',
                'nyear' => 1996,
                'region_id' => 17,
                'big_city_bool' => 0,
                'model' => 'IPSUM',
                'mark' => 'TOYOTA',
                'color' => 'ЗЕЛЕНЫЙ',
                'engine_number' => ''
            ]
        ];

        TestCars::insert($cars);
    }
}
