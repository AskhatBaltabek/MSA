<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BaseTariffsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('base_tariffs')->delete();
        
        \DB::table('base_tariffs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'amount_sum' => 10000,
                'country_id' => 6,
                'amount_premium' => 15.0,
            ),
            1 => 
            array (
                'id' => 2,
                'amount_sum' => 30000,
                'country_id' => 6,
                'amount_premium' => 20.0,
            ),
            2 => 
            array (
                'id' => 3,
                'amount_sum' => 50000,
                'country_id' => 6,
                'amount_premium' => 30.0,
            ),
            3 => 
            array (
                'id' => 4,
                'amount_sum' => 100000,
                'country_id' => 6,
                'amount_premium' => 50.0,
            ),
            4 => 
            array (
                'id' => 5,
                'amount_sum' => 10000,
                'country_id' => 141,
                'amount_premium' => 2.25,
            ),
            5 => 
            array (
                'id' => 6,
                'amount_sum' => 30000,
                'country_id' => 141,
                'amount_premium' => 3.0,
            ),
            6 => 
            array (
                'id' => 7,
                'amount_sum' => 50000,
                'country_id' => 141,
                'amount_premium' => 4.5,
            ),
            7 => 
            array (
                'id' => 8,
                'amount_sum' => 100000,
                'country_id' => 141,
                'amount_premium' => 7.5,
            ),
            8 => 
            array (
                'id' => 9,
                'amount_sum' => 10000,
                'country_id' => 5,
                'amount_premium' => 1.5,
            ),
            9 => 
            array (
                'id' => 10,
                'amount_sum' => 30000,
                'country_id' => 5,
                'amount_premium' => 1.8,
            ),
            10 => 
            array (
                'id' => 11,
                'amount_sum' => 50000,
                'country_id' => 5,
                'amount_premium' => 2.5,
            ),
            11 => 
            array (
                'id' => 12,
                'amount_sum' => 100000,
                'country_id' => 5,
                'amount_premium' => 4.0,
            ),
            12 => 
            array (
                'id' => 13,
                'amount_sum' => 10000,
                'country_id' => 7,
                'amount_premium' => 1.5,
            ),
            13 => 
            array (
                'id' => 14,
                'amount_sum' => 30000,
                'country_id' => 7,
                'amount_premium' => 2.0,
            ),
            14 => 
            array (
                'id' => 15,
                'amount_sum' => 50000,
                'country_id' => 7,
                'amount_premium' => 3.0,
            ),
            15 => 
            array (
                'id' => 16,
                'amount_sum' => 100000,
                'country_id' => 7,
                'amount_premium' => 5.0,
            ),
            16 => 
            array (
                'id' => 18,
                'amount_sum' => 10000,
                'country_id' => 8,
                'amount_premium' => 1.5,
            ),
            17 => 
            array (
                'id' => 19,
                'amount_sum' => 30000,
                'country_id' => 8,
                'amount_premium' => 1.8,
            ),
            18 => 
            array (
                'id' => 20,
                'amount_sum' => 50000,
                'country_id' => 8,
                'amount_premium' => 2.5,
            ),
            19 => 
            array (
                'id' => 21,
                'amount_sum' => 100000,
                'country_id' => 8,
                'amount_premium' => 4.0,
            ),
            20 => 
            array (
                'id' => 22,
                'amount_sum' => 10000,
                'country_id' => 12,
                'amount_premium' => 1.5,
            ),
            21 => 
            array (
                'id' => 23,
                'amount_sum' => 30000,
                'country_id' => 12,
                'amount_premium' => 1.8,
            ),
            22 => 
            array (
                'id' => 24,
                'amount_sum' => 50000,
                'country_id' => 12,
                'amount_premium' => 2.5,
            ),
            23 => 
            array (
                'id' => 25,
                'amount_sum' => 100000,
                'country_id' => 12,
                'amount_premium' => 4.0,
            ),
            24 => 
            array (
                'id' => 26,
                'amount_sum' => 10000,
                'country_id' => 13,
                'amount_premium' => 1.5,
            ),
            25 => 
            array (
                'id' => 27,
                'amount_sum' => 30000,
                'country_id' => 13,
                'amount_premium' => 1.8,
            ),
            26 => 
            array (
                'id' => 28,
                'amount_sum' => 50000,
                'country_id' => 13,
                'amount_premium' => 2.5,
            ),
            27 => 
            array (
                'id' => 29,
                'amount_sum' => 100000,
                'country_id' => 13,
                'amount_premium' => 4.0,
            ),
            28 => 
            array (
                'id' => 30,
                'amount_sum' => 10000,
                'country_id' => 14,
                'amount_premium' => 1.5,
            ),
            29 => 
            array (
                'id' => 31,
                'amount_sum' => 30000,
                'country_id' => 14,
                'amount_premium' => 1.8,
            ),
            30 => 
            array (
                'id' => 32,
                'amount_sum' => 50000,
                'country_id' => 14,
                'amount_premium' => 2.5,
            ),
            31 => 
            array (
                'id' => 33,
                'amount_sum' => 100000,
                'country_id' => 14,
                'amount_premium' => 4.0,
            ),
            32 => 
            array (
                'id' => 34,
                'amount_sum' => 10000,
                'country_id' => 18,
                'amount_premium' => 1.5,
            ),
            33 => 
            array (
                'id' => 35,
                'amount_sum' => 30000,
                'country_id' => 18,
                'amount_premium' => 1.8,
            ),
            34 => 
            array (
                'id' => 36,
                'amount_sum' => 50000,
                'country_id' => 18,
                'amount_premium' => 2.5,
            ),
            35 => 
            array (
                'id' => 37,
                'amount_sum' => 100000,
                'country_id' => 18,
                'amount_premium' => 4.0,
            ),
            36 => 
            array (
                'id' => 38,
                'amount_sum' => 10000,
                'country_id' => 49,
                'amount_premium' => 1.5,
            ),
            37 => 
            array (
                'id' => 39,
                'amount_sum' => 30000,
                'country_id' => 49,
                'amount_premium' => 1.8,
            ),
            38 => 
            array (
                'id' => 40,
                'amount_sum' => 50000,
                'country_id' => 49,
                'amount_premium' => 2.5,
            ),
            39 => 
            array (
                'id' => 41,
                'amount_sum' => 100000,
                'country_id' => 49,
                'amount_premium' => 4.0,
            ),
            40 => 
            array (
                'id' => 42,
                'amount_sum' => 10000,
                'country_id' => 67,
                'amount_premium' => 1.5,
            ),
            41 => 
            array (
                'id' => 43,
                'amount_sum' => 30000,
                'country_id' => 67,
                'amount_premium' => 1.8,
            ),
            42 => 
            array (
                'id' => 44,
                'amount_sum' => 50000,
                'country_id' => 67,
                'amount_premium' => 2.5,
            ),
            43 => 
            array (
                'id' => 45,
                'amount_sum' => 100000,
                'country_id' => 67,
                'amount_premium' => 4.0,
            ),
            44 => 
            array (
                'id' => 46,
                'amount_sum' => 10000,
                'country_id' => 70,
                'amount_premium' => 1.5,
            ),
            45 => 
            array (
                'id' => 47,
                'amount_sum' => 30000,
                'country_id' => 70,
                'amount_premium' => 1.8,
            ),
            46 => 
            array (
                'id' => 48,
                'amount_sum' => 50000,
                'country_id' => 70,
                'amount_premium' => 2.5,
            ),
            47 => 
            array (
                'id' => 49,
                'amount_sum' => 100000,
                'country_id' => 70,
                'amount_premium' => 4.0,
            ),
            48 => 
            array (
                'id' => 50,
                'amount_sum' => 10000,
                'country_id' => 83,
                'amount_premium' => 1.5,
            ),
            49 => 
            array (
                'id' => 51,
                'amount_sum' => 30000,
                'country_id' => 83,
                'amount_premium' => 1.8,
            ),
            50 => 
            array (
                'id' => 52,
                'amount_sum' => 50000,
                'country_id' => 83,
                'amount_premium' => 2.5,
            ),
            51 => 
            array (
                'id' => 53,
                'amount_sum' => 100000,
                'country_id' => 83,
                'amount_premium' => 4.0,
            ),
            52 => 
            array (
                'id' => 54,
                'amount_sum' => 10000,
                'country_id' => 84,
                'amount_premium' => 1.5,
            ),
            53 => 
            array (
                'id' => 55,
                'amount_sum' => 30000,
                'country_id' => 84,
                'amount_premium' => 1.8,
            ),
            54 => 
            array (
                'id' => 56,
                'amount_sum' => 50000,
                'country_id' => 84,
                'amount_premium' => 2.5,
            ),
            55 => 
            array (
                'id' => 57,
                'amount_sum' => 100000,
                'country_id' => 84,
                'amount_premium' => 4.0,
            ),
            56 => 
            array (
                'id' => 58,
                'amount_sum' => 10000,
                'country_id' => 112,
                'amount_premium' => 1.5,
            ),
            57 => 
            array (
                'id' => 59,
                'amount_sum' => 30000,
                'country_id' => 112,
                'amount_premium' => 1.8,
            ),
            58 => 
            array (
                'id' => 60,
                'amount_sum' => 50000,
                'country_id' => 112,
                'amount_premium' => 2.5,
            ),
            59 => 
            array (
                'id' => 61,
                'amount_sum' => 100000,
                'country_id' => 112,
                'amount_premium' => 4.0,
            ),
            60 => 
            array (
                'id' => 62,
                'amount_sum' => 10000,
                'country_id' => 119,
                'amount_premium' => 1.5,
            ),
            61 => 
            array (
                'id' => 63,
                'amount_sum' => 30000,
                'country_id' => 119,
                'amount_premium' => 1.8,
            ),
            62 => 
            array (
                'id' => 64,
                'amount_sum' => 50000,
                'country_id' => 119,
                'amount_premium' => 2.5,
            ),
            63 => 
            array (
                'id' => 65,
                'amount_sum' => 100000,
                'country_id' => 119,
                'amount_premium' => 4.0,
            ),
            64 => 
            array (
                'id' => 66,
                'amount_sum' => 10000,
                'country_id' => 139,
                'amount_premium' => 1.5,
            ),
            65 => 
            array (
                'id' => 67,
                'amount_sum' => 30000,
                'country_id' => 139,
                'amount_premium' => 1.8,
            ),
            66 => 
            array (
                'id' => 68,
                'amount_sum' => 50000,
                'country_id' => 139,
                'amount_premium' => 2.5,
            ),
            67 => 
            array (
                'id' => 69,
                'amount_sum' => 100000,
                'country_id' => 139,
                'amount_premium' => 4.0,
            ),
            68 => 
            array (
                'id' => 70,
                'amount_sum' => 10000,
                'country_id' => 152,
                'amount_premium' => 1.5,
            ),
            69 => 
            array (
                'id' => 71,
                'amount_sum' => 30000,
                'country_id' => 152,
                'amount_premium' => 1.8,
            ),
            70 => 
            array (
                'id' => 72,
                'amount_sum' => 50000,
                'country_id' => 152,
                'amount_premium' => 2.5,
            ),
            71 => 
            array (
                'id' => 73,
                'amount_sum' => 100000,
                'country_id' => 152,
                'amount_premium' => 4.0,
            ),
            72 => 
            array (
                'id' => 74,
                'amount_sum' => 10000,
                'country_id' => 153,
                'amount_premium' => 1.5,
            ),
            73 => 
            array (
                'id' => 75,
                'amount_sum' => 30000,
                'country_id' => 153,
                'amount_premium' => 1.8,
            ),
            74 => 
            array (
                'id' => 76,
                'amount_sum' => 50000,
                'country_id' => 153,
                'amount_premium' => 2.5,
            ),
            75 => 
            array (
                'id' => 77,
                'amount_sum' => 100000,
                'country_id' => 153,
                'amount_premium' => 4.0,
            ),
            76 => 
            array (
                'id' => 78,
                'amount_sum' => 10000,
                'country_id' => 168,
                'amount_premium' => 1.5,
            ),
            77 => 
            array (
                'id' => 79,
                'amount_sum' => 30000,
                'country_id' => 168,
                'amount_premium' => 1.8,
            ),
            78 => 
            array (
                'id' => 80,
                'amount_sum' => 50000,
                'country_id' => 168,
                'amount_premium' => 2.5,
            ),
            79 => 
            array (
                'id' => 81,
                'amount_sum' => 100000,
                'country_id' => 168,
                'amount_premium' => 4.0,
            ),
            80 => 
            array (
                'id' => 82,
                'amount_sum' => 10000,
                'country_id' => 192,
                'amount_premium' => 1.5,
            ),
            81 => 
            array (
                'id' => 83,
                'amount_sum' => 30000,
                'country_id' => 192,
                'amount_premium' => 1.8,
            ),
            82 => 
            array (
                'id' => 84,
                'amount_sum' => 50000,
                'country_id' => 192,
                'amount_premium' => 2.5,
            ),
            83 => 
            array (
                'id' => 85,
                'amount_sum' => 100000,
                'country_id' => 192,
                'amount_premium' => 4.0,
            ),
            84 => 
            array (
                'id' => 86,
                'amount_sum' => 10000,
                'country_id' => 196,
                'amount_premium' => 1.5,
            ),
            85 => 
            array (
                'id' => 87,
                'amount_sum' => 30000,
                'country_id' => 196,
                'amount_premium' => 1.8,
            ),
            86 => 
            array (
                'id' => 88,
                'amount_sum' => 50000,
                'country_id' => 196,
                'amount_premium' => 2.5,
            ),
            87 => 
            array (
                'id' => 89,
                'amount_sum' => 100000,
                'country_id' => 196,
                'amount_premium' => 4.0,
            ),
            88 => 
            array (
                'id' => 90,
                'amount_sum' => 10000,
                'country_id' => 198,
                'amount_premium' => 1.5,
            ),
            89 => 
            array (
                'id' => 91,
                'amount_sum' => 30000,
                'country_id' => 198,
                'amount_premium' => 1.8,
            ),
            90 => 
            array (
                'id' => 92,
                'amount_sum' => 50000,
                'country_id' => 198,
                'amount_premium' => 2.5,
            ),
            91 => 
            array (
                'id' => 93,
                'amount_sum' => 100000,
                'country_id' => 198,
                'amount_premium' => 4.0,
            ),
            92 => 
            array (
                'id' => 94,
                'amount_sum' => 10000,
                'country_id' => 200,
                'amount_premium' => 1.5,
            ),
            93 => 
            array (
                'id' => 95,
                'amount_sum' => 30000,
                'country_id' => 200,
                'amount_premium' => 1.8,
            ),
            94 => 
            array (
                'id' => 96,
                'amount_sum' => 50000,
                'country_id' => 200,
                'amount_premium' => 2.5,
            ),
            95 => 
            array (
                'id' => 97,
                'amount_sum' => 100000,
                'country_id' => 200,
                'amount_premium' => 4.0,
            ),
            96 => 
            array (
                'id' => 98,
                'amount_sum' => 10000,
                'country_id' => 107,
                'amount_premium' => 1.5,
            ),
            97 => 
            array (
                'id' => 99,
                'amount_sum' => 30000,
                'country_id' => 107,
                'amount_premium' => 1.8,
            ),
            98 => 
            array (
                'id' => 100,
                'amount_sum' => 50000,
                'country_id' => 107,
                'amount_premium' => 2.5,
            ),
            99 => 
            array (
                'id' => 101,
                'amount_sum' => 100000,
                'country_id' => 107,
                'amount_premium' => 4.0,
            ),
            100 => 
            array (
                'id' => 102,
                'amount_sum' => 10000,
                'country_id' => 113,
                'amount_premium' => 1.5,
            ),
            101 => 
            array (
                'id' => 103,
                'amount_sum' => 30000,
                'country_id' => 113,
                'amount_premium' => 1.8,
            ),
            102 => 
            array (
                'id' => 104,
                'amount_sum' => 50000,
                'country_id' => 113,
                'amount_premium' => 2.5,
            ),
            103 => 
            array (
                'id' => 105,
                'amount_sum' => 100000,
                'country_id' => 113,
                'amount_premium' => 4.0,
            ),
            104 => 
            array (
                'id' => 106,
                'amount_sum' => 10000,
                'country_id' => 138,
                'amount_premium' => 1.5,
            ),
            105 => 
            array (
                'id' => 107,
                'amount_sum' => 30000,
                'country_id' => 138,
                'amount_premium' => 1.8,
            ),
            106 => 
            array (
                'id' => 108,
                'amount_sum' => 50000,
                'country_id' => 138,
                'amount_premium' => 2.5,
            ),
            107 => 
            array (
                'id' => 109,
                'amount_sum' => 100000,
                'country_id' => 138,
                'amount_premium' => 4.0,
            ),
            108 => 
            array (
                'id' => 110,
                'amount_sum' => 10000,
                'country_id' => 169,
                'amount_premium' => 1.5,
            ),
            109 => 
            array (
                'id' => 111,
                'amount_sum' => 30000,
                'country_id' => 169,
                'amount_premium' => 1.8,
            ),
            110 => 
            array (
                'id' => 112,
                'amount_sum' => 50000,
                'country_id' => 169,
                'amount_premium' => 2.5,
            ),
            111 => 
            array (
                'id' => 113,
                'amount_sum' => 100000,
                'country_id' => 169,
                'amount_premium' => 4.0,
            ),
            112 => 
            array (
                'id' => 114,
                'amount_sum' => 10000,
                'country_id' => 213,
                'amount_premium' => 1.5,
            ),
            113 => 
            array (
                'id' => 115,
                'amount_sum' => 30000,
                'country_id' => 213,
                'amount_premium' => 1.8,
            ),
            114 => 
            array (
                'id' => 116,
                'amount_sum' => 50000,
                'country_id' => 213,
                'amount_premium' => 2.5,
            ),
            115 => 
            array (
                'id' => 117,
                'amount_sum' => 100000,
                'country_id' => 213,
                'amount_premium' => 4.0,
            ),
        ));
        
        
    }
}