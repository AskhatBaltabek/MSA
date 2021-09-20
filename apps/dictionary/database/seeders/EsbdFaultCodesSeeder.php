<?php

namespace Database\Seeders;

use App\Models\EsbdFaultCode;
use App\Models\Franchise;
use Illuminate\Database\Seeder;

class EsbdFaultCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $errors = [
            [
                "id" => 43,
                "title" => "Client verification WS is turned off. Доступ к сервису \"Верификация клиента\" отключен",
                "code" => "EWS-1001"
            ],
            [
                "id" => 41,
                "title" => "Vehicle verification WS is turned off. Доступ к сервису \"Автомобиль\" отключен",
                "code" => "EWS-2001"
            ],
            [
                "id" => 57,
                "title" => "Vehicle verification WS error. Ошибка при обращении к сервису \"Автомобиль\"",
                "code" => "EWS-2002"
            ],
            [
                "id" => 15,
                "title" => "Driver verification WS is turned off. Доступ к сервису \"Верификация Водителя\" отключен",
                "code" => "EWS-3001"
            ],
            [
                "id" => 28,
                "title" => "Priveleged status verification WS is turned off. Доступ к сервису отключен",
                "code" => "EWS-4001"
            ],
            [
                "id" => 19,
                "title" => "WS call error. Ошибка при вызове веб-сервиса []",
                "code" => "EWS-0001"
            ],
            [
                "id" => 44,
                "title" => "Driver offline verification error. Ошибка оффлайн сверки ВУ.  Нет данных ",
                "code" => "EDL-0009"
            ],
        ];

        foreach ($errors as $value) {
            $error = EsbdFaultCode::find($value['id']);
            if($error) {
                $error->update($value);
            }
            else
                EsbdFaultCode::create($value);
        }
    }
}
