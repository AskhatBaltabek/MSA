<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title'   => 'Легковые',
                'esbd_id' => 4
            ],
            [
                'title'   => 'Автобусы до 16 п.м.',
                'esbd_id' => 5
            ],
            [
                'title'   => 'Грузовые',
                'esbd_id' => 6
            ],
            [
                'title'   => 'Троллейбусы, трамваи',
                'esbd_id' => 7
            ],
            [
                'title'   => 'Мототранспорт',
                'esbd_id' => 8
            ],
            [
                'title'   => 'Прицепы(полуприцепы)',
                'esbd_id' => 10
            ],
            [
                'title'   => 'Автобусы > 16 п.м.',
                'esbd_id' => 11
            ],
            [
                'title'   => 'Воздушный',
                'esbd_id' => 12
            ],
            [
                'title'   => 'Морской',
                'esbd_id' => 13
            ],
            [
                'title'   => 'Железнодорожный',
                'esbd_id' => 14
            ],
            [
                'title'   => 'Спец.техника',
                'esbd_id' => 15
            ],
        ];

        foreach ($data as $item) {
            VehicleType::create([
                'title'   => $item['title'],
                'esbd_id' => $item['esbd_id']
            ]);
        }
    }
}
