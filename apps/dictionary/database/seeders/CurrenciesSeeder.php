<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [1, 'тенге', 'KZT'],
            [2, 'доллар США', 'USD'],
            [3, 'евро', 'EUR'],
            [4, 'рубль Россия', 'RUB'],
            [5, 'йены Япония', 'JPY']
        ];

        foreach ($currencies as $value) {
            $value = [
                'id' => $value[0],
                'title' => $value[1],
                'code' => $value[2],
            ];

            $currency = Currency::find($value['id']);
            if($currency) {
                $currency->update($value);
            }
            else
                Currency::create($value);
        }
    }
}
