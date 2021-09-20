<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tariffs = [
            [1, 1, 1, 10, 1.2],
            [2, 1, 11, 20, 1.12],
            [3, 1, 21, 40, 1.12],
            [4, 1, 41, 60, 1.03],
            [5, 1, 61, 90, 1.03],
            [6, 1, 91, 999999999, 0.95],
            [7, 2, 1, 10, 1.51],
            [8, 2, 11, 20, 1.48],
            [9, 2, 21, 40, 1.43],
            [10, 2, 41, 60, 1.4],
            [11, 2, 61, 90, 1.35],
            [12, 2, 91, 999999999, 1.3],
            [13, 3, 1, 10, 1.83],
            [14, 3, 11, 20, 1.7],
            [15, 3, 21, 40, 1.59],
            [16, 3, 41, 60, 1.53],
            [17, 3, 61, 90, 1.48],
            [18, 3, 91, 999999999, 1.4],
        ];

        foreach ($tariffs as $value)
        {
            $value = [
                'id' => $value[0],
                'program_id' => $value[1],
                'min' => $value[2],
                'max' => $value[3],
                'value' => $value[4],
            ];

            $tariff = Tariff::find($value['id']);
            if($tariff) {
                $tariff->update($value);
            }
            else {
                Tariff::create($value);
            }
        }
    }
}
