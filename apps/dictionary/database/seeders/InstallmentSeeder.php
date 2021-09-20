<?php

namespace Database\Seeders;

use App\Models\Installment;
use Illuminate\Database\Seeder;

class InstallmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $installments = [
            [
                'id' => 1,
                'program_id' => 4,
                'title' => '1 месяц',
                'months' => 1,
                'coefficient' => 1,
            ],
            [
                'id' => 2,
                'program_id' => 4,
                'title' => '2 месяц',
                'months' => 2,
                'coefficient' => 1,
            ],
            [
                'id' => 3,
                'program_id' => 4,
                'title' => '3 месяц',
                'months' => 3,
                'coefficient' => 1,
            ],
            [
                'id' => 4,
                'program_id' => 4,
                'title' => '4 месяц',
                'months' => 4,
                'coefficient' => 1,
            ],
            [
                'id' => 5,
                'program_id' => 4,
                'title' => '5 месяц',
                'months' => 5,
                'coefficient' => 1,
            ],
            [
                'id' => 6,
                'program_id' => 4,
                'title' => '6 месяц',
                'months' => 6,
                'coefficient' => 1,
            ],
            [
                'id' => 7,
                'program_id' => 4,
                'title' => '7 месяц',
                'months' => 7,
                'coefficient' => 1,
            ],
            [
                'id' => 8,
                'program_id' => 4,
                'title' => '8 месяц',
                'months' => 8,
                'coefficient' => 1,
            ],
            [
                'id' => 9,
                'program_id' => 4,
                'title' => '9 месяц',
                'months' => 9,
                'coefficient' => 1,
            ],
            [
                'id' => 10,
                'program_id' => 4,
                'title' => '10 месяц',
                'months' => 10,
                'coefficient' => 1,
            ],
            [
                'id' => 11,
                'program_id' => 4,
                'title' => '11 месяц',
                'months' => 11,
                'coefficient' => 1,
            ],
            [
                'id' => 12,
                'program_id' => 4,
                'title' => '12 месяц',
                'months' => 12,
                'coefficient' => 1,
            ],
        ];

        foreach ($installments as $value) {
            $installment = Installment::find($value['id']);
            if($installment) {
                $installment->update($value);
            }
            else
                Installment::create($value);
        }
    }
}
