<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::truncate();

        $documentTypes = [
            [
                'title'   => 'Удостоверение личности',
                'esbd_id' => 1
            ],
            [
                'title'   => 'Паспорт',
                'esbd_id' => 2
            ],
            [
                'title'   => 'Свидетельство о рождении',
                'esbd_id' => 3
            ],
            [
                'title'   => 'Вид на жительство иностранца',
                'esbd_id' => 4
            ],
            [
                'title'   => 'Дипломатический паспорт',
                'esbd_id' => 5
            ],
            [
                'title'   => 'Справка об отсутствии или наличии судимости',
                'esbd_id' => 6
            ],
            [
                'title'   => 'Свидетельство о государственной регистрации (перерегистрации) юридического лица',
                'esbd_id' => 7
            ],
            [
                'title'   => 'Сертификат лица без гражданства',
                'esbd_id' => 8
            ],
        ];

        foreach ($documentTypes as $type) {
            DocumentType::create([
                'title'   => $type['title'],
                'esbd_id' => $type['esbd_id'],
            ]);
        }
    }
}
