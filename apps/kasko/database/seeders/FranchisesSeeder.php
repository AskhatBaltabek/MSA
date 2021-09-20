<?php

namespace Database\Seeders;

use App\Models\Franchise;
use Illuminate\Database\Seeder;

class FranchisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $franchises = [
            [
                'id' => 1,
                'product_code' => 200,
                'tarif' => 0.012,
                'franchise_damage' => '10% от страховой суммы, но не менее 500 000 тенге',
                'coef_damage' => 0.1,
                'operator_damage' => '<',
                'min_sum_damage' => 500000,
                'franchise_loss' => '10% от страховой суммы, но не менее чем размер франшизы по риску "повреждение"',
                'coef_loss' => 0.1,
            ],
            [
                'id' => 2,
                'product_code' => 200,
                'tarif' => 0.017,
                'franchise_damage' => '5% от страховой суммы, но не более 800 000 тенге',
                'coef_damage' => 0.05,
                'operator_damage' => '>',
                'min_sum_damage' => 800000,
                'franchise_loss' => '10% от страховой суммы, но не менее чем размер франшизы по риску "повреждение"',
                'coef_loss' => 0.1,
            ],
            [
                'id' => 3,
                'product_code' => 200,
                'tarif' => 0.019,
                'franchise_damage' => '2% от страховой суммы, но не более 800 000 тенге',
                'coef_damage' => 0.02,
                'operator_damage' => '>',
                'min_sum_damage' => 800000,
                'franchise_loss' => '10% от страховой суммы, но не менее чем размер франшизы по риску "повреждение"',
                'coef_loss' => 0.1,
            ],
            [
                'id' => 4,
                'product_code' => 200,
                'tarif' => 0.023,
                'franchise_damage' => '1% от страховой суммы, но не менее 150 000 тенге',
                'coef_damage' => 0.01,
                'operator_damage' => '<',
                'min_sum_damage' => 150000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 5,
                'product_code' => 200,
                'tarif' => 0.026,
                'franchise_damage' => '0.5% от страховой суммы, но не менее 75 000 тенге',
                'coef_damage' => 0.005,
                'operator_damage' => '<',
                'min_sum_damage' => 75000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 6,
                'product_code' => 200,
                'tarif' => 0.03,
                'franchise_damage' => '0.25% от страховой суммы, но не менее 45 000 тенге',
                'coef_damage' => 0.0025,
                'operator_damage' => '<',
                'min_sum_damage' => 45000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 7,
                'product_code' => 200,
                'tarif' => 0.035,
                'franchise_damage' => 'Без франшизы',
                'coef_damage' => 0,
                'operator_damage' => '<',
                'min_sum_damage' => 0,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 8,
                'product_code' => 206,
                'tarif' => 0.029,
                'franchise_damage' => '1% от страховой суммы, но не менее 150 000 тенге',
                'coef_damage' => 0.01,
                'operator_damage' => '<',
                'min_sum_damage' => 150000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 9,
                'product_code' => 206,
                'tarif' => 0.033,
                'franchise_damage' => '0.5% от страховой суммы, но не менее 90 000 тенге',
                'coef_damage' => 0.005,
                'operator_damage' => '<',
                'min_sum_damage' => 90000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 10,
                'product_code' => 206,
                'tarif' => 0.039,
                'franchise_damage' => '0.25% от страховой суммы, но не менее 45 000 тенге',
                'coef_damage' => 0.0025,
                'operator_damage' => '<',
                'min_sum_damage' => 45000,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
            [
                'id' => 11,
                'product_code' => 206,
                'tarif' => 0.046,
                'franchise_damage' => 'Без франшизы',
                'coef_damage' => 0,
                'operator_damage' => '<',
                'min_sum_damage' => 0,
                'franchise_loss' => '5% от страховой суммы каждого объекта отдельно',
                'coef_loss' => 0.05,
            ],
        ];

        foreach ($franchises as $value) {
            $franchise = Franchise::find($value['id']);
            if($franchise) {
                $franchise->update($value);
            }
            else {
                Franchise::create($value);
            }
        }
    }
}
