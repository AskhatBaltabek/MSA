<?php

namespace Database\Seeders;

use App\Models\Franchise;
use App\Models\PolicyStatus;
use Illuminate\Database\Seeder;

class PolicyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id' => 0,
                'title' => 'Черновик',
            ],
            [
                'id' => 1,
                'title' => 'Проведен в 1С',
            ],
            [
                'id' => 6,
                'title' => 'Ошибка оператора'
            ]
        ];

        foreach ($statuses as $value) {
            $status = PolicyStatus::find($value['id']);
            if($status) {
                $status->update($value);
            }
            else {
                PolicyStatus::create($value);
            }
        }
    }
}
