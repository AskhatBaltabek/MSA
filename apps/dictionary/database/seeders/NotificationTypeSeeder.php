<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id' => 1,
                'title' => 'SMS'
            ],
            [
                'id' => 2,
                'title' => 'Email'
            ],
            [
                'id' => 3,
                'title' => 'Both (SMS и Email)'
            ],
            [
                'id' => 4,
                'title' => 'Нарочно'
            ],
        ];

        foreach ($types as $type)
        {
            NotificationType::create($type);
        }
    }
}
