<?php

namespace Database\Seeders;

use App\Models\InsuranceTerritory;
use Illuminate\Database\Seeder;

class InsuranceTerritoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsuranceTerritory::truncate();

        $terr = [
            [
                'title' => 'Весь мир, за исключением Украины и зон военных действий',
                'coefficient' => '1.25',
            ],
            [
                'title' => 'Республика Казахстан, Кыргызская Республика',
                'coefficient' => '1',
            ],
        ];

        foreach ($terr as $value) {
            $territory = InsuranceTerritory::firstWhere('title', $value['title']);
            if($territory) {
                $territory->update($value);
            } else {
                InsuranceTerritory::create($value);
            }

        }
    }
}
