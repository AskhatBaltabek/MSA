<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurposesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purposes')->delete();
        
        \DB::table('purposes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Туризм',
                'coef' => '0',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Профессиональный спорт',
                'coef' => '2',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Обучение',
                'coef' => '0',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Командировка',
                'coef' => '0',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Активный отдых',
                'coef' => '2',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Трудоустройство',
                'coef' => '2',
            ),
        ));
        
        
    }
}