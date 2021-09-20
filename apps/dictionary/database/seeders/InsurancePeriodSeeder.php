<?php

namespace Database\Seeders;

use App\Models\InsurancePeriod;
use Illuminate\Database\Seeder;

class InsurancePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periods = [
            [
                'id' => 1,
                'program_id' => 4,
                'title' => 'До 1 месяца',
                'coefficient' => '0.3',
                'max_payments' => 1,
            ],
            [
                'id' => 2,
                'program_id' => 4,
                'title' => 'От 1 до 2 месяцев',
                'coefficient' => '0.4',
                'max_payments' => 2,
            ],
            [
                'id' => 3,
                'program_id' => 4,
                'title' => 'От 2 до 3 месяцев',
                'coefficient' => '0.5',
                'max_payments' => 3,
            ],
            [
                'id' => 4,
                'program_id' => 4,
                'title' => 'От 3 до 4 месяцев',
                'coefficient' => '0.6',
                'max_payments' => 4,
            ],
            [
                'id' => 5,
                'program_id' => 4,
                'title' => 'От 4 до 5 месяцев',
                'coefficient' => '0.65',
                'max_payments' => 5,
            ],
            [
                'id' => 6,
                'program_id' => 4,
                'title' => 'От 5 до 6 месяцев',
                'coefficient' => '0.7',
                'max_payments' => 6,
            ],
            [
                'id' => 7,
                'program_id' => 4,
                'title' => 'От 6 до 7 месяцев',
                'coefficient' => '0.75',
                'max_payments' => 7,
            ],
            [
                'id' => 8,
                'program_id' => 4,
                'title' => 'От 7 до 8 месяцев',
                'coefficient' => '0.8',
                'max_payments' => 8,
            ],
            [
                'id' => 9,
                'program_id' => 4,
                'title' => 'От 8 до 9 месяцев',
                'coefficient' => '0.85',
                'max_payments' => 9,
            ],
            [
                'id' => 10,
                'program_id' => 4,
                'title' => 'От 9 до 10 месяцев',
                'coefficient' => '0.9',
                'max_payments' => 11,
            ],
            [
                'id' => 11,
                'program_id' => 4,
                'title' => 'От 10 до 11 месяцев',
                'coefficient' => '0.95',
                'max_payments' => 11,
            ],
            [
                'id' => 12,
                'program_id' => 4,
                'title' => '12 месяцев',
                'coefficient' => '1',
                'max_payments' => 12,
            ],
        ];

        foreach ($periods as $value) {
            $period = InsurancePeriod::find($value['id']);
            if($period) {
                $period->update($value);
            }
            else
                InsurancePeriod::create($value);
        }
    }
}
