<?php

namespace Database\Seeders;

use App\Models\ProductSetting;
use Illuminate\Database\Seeder;

class ProductsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductSetting::truncate();

        $settings = [
            [
                'product_id_1c' => 31,
                'program_id' => 4,
                'title' => 'Стоимость авто – max. лимит на один объект по Каско (200)',
                'key' => 'max_limit_kasko',
                'value' => '50000000',
            ],
            [
                'product_id_1c' => 35,
                'program_id' => 4,
                'title' => 'Стоимость авто – max. лимит на один объект по Гранд Каско (206)',
                'key' => 'max_limit_grand_kasko',
                'value' => '50000000',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Max возраст авто (Без учета амортизации)',
                'key' => 'max_age_without_amortization',
                'value' => '10',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Max возраст авто (С учетом амортизации)',
                'key' => 'max_age_with_amortization',
                'value' => '5',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Порог коэфф. убыточности (физ. лица)',
                'key' => 'coef_unprofitable_fl',
                'value' => '50',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Порог коэфф. убыточности (юр. лица)',
                'key' => 'coef_unprofitable_ul',
                'value' => '50',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Max. лимит коэф. страховой суммы',
                'key' => 'max_coef_ins_sum',
                'value' => '30',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Min. лимит коэф. страховой суммы',
                'key' => 'min_coef_ins_sum',
                'value' => '10',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Default лимит коэф. страховой суммы',
                'key' => 'default_coef_ins_sum',
                'value' => '5',
            ],
            [
                'product_id_1c' => NULL,
                'program_id' => 4,
                'title' => 'Максимальный лимит страховой суммы',
                'key' => 'max_limit_ins_sum',
                'value' => '400000000',
            ],
            [
                'product_id_1c' => 31,
                'program_id' => 4,
                'title' => 'Максимальный тариф по КАСКО (200)',
                'key' => 'max_tariff_kasko',
                'value' => '15',
            ],
            [
                'product_id_1c' => 35,
                'program_id' => 4,
                'title' => 'Максимальный тариф по Гранд Каско (206)',
                'key' => 'max_tariff_grand_kasko',
                'value' => '15',
            ]
        ];

        ProductSetting::insert($settings);

        $settings = [
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Шанырак: 19,990 тенге',
                'key' => 'insurance_program',
                'value' => 19990,
                'position' => 1,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Алтын Шанырак: 44,990 тенге',
                'key' => 'insurance_program',
                'value' => 44990,
                'position' => 2,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Страхование имущества Шанырак',
                'key' => 'property',
                'value' => '4800000',
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Страхование ГПО за причинение вреда',
                'key' => 'damage',
                'value' => '1200000',
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Страхование имущества А-Шанырак',
                'key' => 'property',
                'value' => 8000000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Страхование ГПО за причинение вреда',
                'key' => 'damage',
                'value' => 2000000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Франшиза Шанырак',
                'key' => 'franchise',
                'value' => 50000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Франшиза А-Шанырак',
                'key' => 'franchise',
                'value' => 75000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Премия ГПО Шанырак',
                'key' => 'damage_premium',
                'value' => 6000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Премия ГПО А-Шанырак',
                'key' => 'damage_premium',
                'value' => 10000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Ид ГПО в 1С Шанырак',
                'key' => 'gpo_id_1c',
                'value' => 53,
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'Ид ГПО в 1С А-Шанырак',
                'key' => 'gpo_id_1c',
                'value' => 53,
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'ID Вида Объекта в 1С',
                'key' => 'object_type_id_1c',
                'value' => 394,
                'position' => 0,
            ],
            [
                'product_id_1c' => 106,
                'program_id' => 5,
                'title' => 'ID Вида Объекта в 1С',
                'key' => 'object_type_id_1c',
                'value' => 394,
                'position' => 0,
            ],
            [
                'product_id_1c' => 105,
                'program_id' => 5,
                'title' => 'Код продукта Шанырак',
                'key' => 'shanyrak_product_code',
                'value' => 120,
                'position' => 0,
            ],
        ];

        ProductSetting::insert($settings);

        $settings = [
            [
                'product_id_1c' => 129,
                'program_id' => NULL,
                'title' => 'Возраст клиента для расчета продукта ОСТ',
                'key' => 'age_limit',
                'value' => 65,
                'position' => 0,
            ],
            [
                'product_id_1c' => 129,
                'program_id' => NULL,
                'title' => 'ID ESBD карточки туроператора',
                'key' => 'client_id_turoperator',
                'value' => 32941508,
                'position' => 0,
            ],
            [
                'product_id_1c' => 129,
                'program_id' => NULL,
                'title' => 'Номер контракта туроператора',
                'key' => 'contract_number_turoperator',
                'value' => 12345,
                'position' => 0,
            ],
            [
                'product_id_1c' => 129,
                'program_id' => NULL,
                'title' => 'ОСТ продукт ID 1c',
                'key' => 'ost_product_id',
                'value' => 129,
                'position' => 0,
            ],
        ];

        ProductSetting::insert($settings);

        $settings = [
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'Страхование жилья',
                'key' => 'insurance_program',
                'value' => 25000,
                'position' => 0,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'Страхование имущества',
                'key' => 'property',
                'value' => 3150000,
                'position' => 1,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'Страхование ГПО за причинение вреда',
                'key' => 'damage',
                'value' => 1500000,
                'position' => 2,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'Франшиза Шанырак',
                'key' => 'franchise',
                'value' => 50000,
                'position' => 3,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'Премия ГПО Шанырак',
                'key' => 'damage_premium',
                'value' => 8500,
                'position' => 4,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'ID ГПО в 1С Шанырак',
                'key' => 'gpo_id_1c',
                'value' => 53,
                'position' => 5,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'ID Вида Объекта в 1С',
                'key' => 'object_type_id_1c',
                'value' => 394,
                'position' => 6,
            ],
            [
                'product_id_1c' => 140,
                'program_id' => NULL,
                'title' => 'ID продукта Шанырак в 1С',
                'key' => 'shanyrak_product_id_1c',
                'value' => 140,
                'position' => 7,
            ],
        ];

        ProductSetting::insert($settings);
    }
}
