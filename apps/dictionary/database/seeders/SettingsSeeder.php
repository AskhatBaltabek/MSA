<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        $settings = [
            [1, 'age_limit', 'Возраст клиента для расчета продукта ОСТ', '{"value":"65"}'],
            [2, 'client_id_turoperator', 'ID ESBD карточки туроператора', '{"value":"32941508"}'],
            [3, 'contract_number_turoperator', 'Номер контракта туроператора', '{"value":"12345"}'],
            [4, 'verify_bool', 'Гос. сверка', '{"value":"0", "manual":1}'],
            [
                5,
                'mkb_urls',
                'Сервера ЕСБД',
                '[
                    {"url":"https://testesbd.mkb.kz:8077/iicwebservice.asmx", "active":"1"},
                    {"url":"https://testesbd.mkb.kz:8077/iicwebservice.asmx", "active":"0"},
                    {"url":"https://testesbd.mkb.kz:8077/iicwebservice.asmx", "active":"0"},
                    {"url":"https://testesbd.mkb.kz:8077/iicwebservice.asmx", "active":"0"}
                ]'
            ],
            [
                6,
                'test_user_for_get_premium',
                'Тестовый клиент для GetPremium',
                '{
                    "date_begin": "31.05.2021",
                    "date_end": "30.05.2022",
                    "clients": [{
                        "holder_type": 0,
                        "client_id": 32941413,
                        "iin": "930421400841",
                        "first_name": "МАРАЛ",
                        "middle_name": "",
                        "last_name": "КУЛЖАБАЕВА",
                        "natural_person_bool": 1,
                        "class_id": 5,
                        "born": "21.04.1993",
                        "sex_id": 2,
                        "resident_bool": 1,
                        "bonus_malus": "M",
                        "document_number": "",
                        "document_gived_date": "",
                        "document_type_id": "",
                        "age_experience_id": 1,
                        "priveleger_bool": 0
                    }],
                    "cars": [{
                        "tf_id": 1786217,
                        "type_id": 4,
                        "vin": "SXM100002162",
                        "reg_num": "024ZNA05",
                        "reg_cert_num": "BQ00124775",
                        "dt_reg_cert": "23.08.2016",
                        "nyear": "1996",
                        "region_id": 1,
                        "big_city_bool": 0,
                        "model": "IPSUM",
                        "mark": "TOYOTA",
                        "color": "ЗЕЛЕНЫЙ",
                        "engine_number": ""
                    }]
                }'
            ]
        ];

        foreach ($settings as $value)
        {
            $value = [
                'id' => $value[0],
                'key' => $value[1],
                'title' => $value[2],
                'setting' => $value[3],
            ];

            $setting = Setting::find($value['id']);
            if($setting)
                $setting->update($value);
            else
                Setting::create($value);
        }
    }
}
