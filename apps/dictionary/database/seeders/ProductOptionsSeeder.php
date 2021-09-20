<?php

namespace Database\Seeders;

use App\Models\ProductOption;
use Illuminate\Database\Seeder;

class ProductOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductOption::truncate();

        $options = [
            [
                'product_id_1с' => 31,
                'option_id' => 1,
                'checked' => 0,
            ],
            [
                'product_id_1с' => 31,
                'option_id' => 2,
                'checked' => 0,
            ],
            [
                'product_id_1с' => 31,
                'option_id' => 3,
                'checked' => 0,
            ],
            [
                'product_id_1с' => 35,
                'option_id' => 1,
                'checked' => 0,
            ],
            [
                'product_id_1с' => 35,
                'option_id' => 2,
                'checked' => 0,
            ],
            [
                'product_id_1с' => 35,
                'option_id' => 3,
                'checked' => 0,
            ],
        ];

        ProductOption::insert($options);
    }
}
