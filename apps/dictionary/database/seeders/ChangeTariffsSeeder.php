<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class ChangeTariffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tariffs = [
            ["id" => 1, "program_id" => 1, "min" => 1, "max" => 10, "value" => 1.5],
            ["id" => 2, "program_id" => 1, "min" => 11, "max" => 20, "value" => 1.5],
            ["id" => 3, "program_id" => 1, "min" => 21, "max" => 40, "value" => 1.5],
            ["id" => 4, "program_id" => 1, "min" => 41, "max" => 60, "value" => 1.38],
            ["id" => 5, "program_id" => 1, "min" => 61, "max" => 90, "value" => 1.38],
            ["id" => 6, "program_id" => 1, "min" => 91, "max" => 999999999, "value" => 1.27],

            ["id" => 7, "program_id" => 2, "min" => 1, "max" => 10, "value" => 2.02],
            ["id" => 8, "program_id" => 2, "min" => 11, "max" => 20, "value" => 1.98],
            ["id" => 9, "program_id" => 2, "min" => 21, "max" => 40, "value" => 1.92],
            ["id" => 10, "program_id" => 2, "min" => 41, "max" => 60, "value" => 1.88],
            ["id" => 11, "program_id" => 2, "min" => 61, "max" => 90, "value" => 1.81],
            ["id" => 12, "program_id" => 2, "min" => 91, "max" => 999999999, "value" => 1.74],

            ["id" => 13, "program_id" => 3, "min" => 1, "max" => 10, "value" => 2.45],
            ["id" => 14, "program_id" => 3, "min" => 11, "max" => 20, "value" => 2.28],
            ["id" => 15, "program_id" => 3, "min" => 21, "max" => 40, "value" => 2.13],
            ["id" => 16, "program_id" => 3, "min" => 41, "max" => 60, "value" => 2.05],
            ["id" => 17, "program_id" => 3, "min" => 61, "max" => 90, "value" => 1.98],
            ["id" => 18, "program_id" => 3, "min" => 91, "max" => 999999999, "value" => 1.88]
        ];

        foreach ($tariffs as $value) {
            $tariff = Tariff::find($value['id']);
            if ($tariff) {
                $tariff->value = $value['value'];
                $tariff->update();
            }
        }
    }
}
