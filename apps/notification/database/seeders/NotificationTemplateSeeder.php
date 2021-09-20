<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'code'     => 'email-ost',
                'theme_ru' => 'УВЕДОМЛЕНИЕ/ХАБАРЛАМА [{{ $args["created_at"] }}]',
                'body_ru'  => '<p>Уважаемый(ая) {{ $args["full_name"] }},<br />
                Рады видеть вас в числе клиентов АО &laquo;Страховая компания &laquo;Amanat&raquo;!<br />
                Уникальный номер вашего договора страхования - {{ $args["global_id"] }}.<br />
                Проверить полис по уникальному номеру можно на сайте <a href="https://id.mkb.kz/">https://id.mkb.kz</a></p>
                <p>Для просмотра полиса и сертификата скачайте файл, вложенный в письмо.<br />
                Благодарим за выбор!</p>
                <p>amanat24.kz</p>',
            ],
            [
                'code'     => 'sms-ost',
                'theme_ru' => 'Уведомление о выписке ОСТ',
                'body_ru'  => 'Застрахованный: {{ $args["full_name"] }}.' . PHP_EOL . 'Полис: {{ $args["global_id"] }}.' . PHP_EOL . 'Сертификат: {{ $args["certificate_number"] }}.',
            ],
            [
                'code'     => 'email-ost-mst',
                'theme_ru' => 'УВЕДОМЛЕНИЕ/ХАБАРЛАМА [{{ $args["created_at"] }}]',
                'body_ru'  => '<html>
<head>
    <title>СТРАХОВОЙ СЕРТИФИКАТ ОБЯЗАТЕЛЬНОГО СТРАХОВАНИЯ ТУРИСТА</title>
    <style>
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        .page-contract {
            position: relative;
            display: block;
            width: 200mm;
            height: 209mm;
        }

        table {
            font-size: 12px;
            margin: 0 0 2mm 0;
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid #000;
            padding: 1.4mm;
        }

    </style>
</head>
<body>
<div class="page-contract">
    <p>Здравствуйте, {{ $args["full_name"] }}!<br/>Рады видеть Вас в числе клиентов АО &laquo;Страховая компания &laquo;Amanat&raquo;<br/><br/>Уведомляем
        о заключении договора обязательного страхования туриста</p>
    <table>
        <tbody>
        <tr valign="top">
            <td>
                <p>Страхователь</p>
            </td>
            <td>
                <p>{{ $args["tour_operator_name"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Застрахованный</p>
            </td>
            <td>
                <p>{{ $args["full_name"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Обязательное страхование туриста</p>
            </td>
            <td>
                <p>Сертификат {{ $args["certificate_number"] }}</p>
                <p>Уникальный номер ЕСБД {{ $args["global_id"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Период действия</p>
            </td>
            <td>
                <p>{{ $args["date_begin"] }} - {{ $args["date_end"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Территория страхования</p>
            </td>
            <td>
                <p>{{ $args["trip_countries"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Объект страхования</p>
            </td>
            <td>
                <p>Причинение имущественного вреда здоровью или жизни в результате наступления страховых случаев</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Страховая сумма</p>
            </td>
            <td>
                <p>{{ $args["amount"] }} {{ $args["amount_cur"] }}</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>Страховая премия</p>
            </td>
            <td>
                <p>{{ $args["premium"] }} {{ $args["premium_cur"] }}</p>
            </td>
        </tr>
        </tbody>
    </table>
    <p>Проверить договор по уникальному номеру можно на сайте <a href="https://id.mkb.kz/">https://id.mkb.kz</a></p>
    <br/>
    @if(isset($args["certificate_number_mst"]))
    <p>Добровольное страхование: Памятка {{ $args["certificate_number_mst"] }}; Уникальный номер ЕСБД {{ $args["global_id_mst"] }}</p><br/>
    @endif

    <p>Для просмотра подробной информации об условиях страхования, скачайте файл(-ы), вложенные в письмо.<br/>Благодарим
        за выбор!</p>
    <p><a href="https://amanat24.kz ">amanat24.kz</a></p>
    <br/><br/>
    <p>Из Правил страхования обязательного страхования туриста:</p>
    <table>
        <tbody>
        <tr valign="top">
            <td>
                <strong>Действия страхователя и застрахованного при наступлении страхового случая</strong>
            </td>
            <td>
                <strong>47. Страхователь обязан:</strong>
                <p>1) в срок не позднее двух рабочих дней, когда ему стало известно о наступлении страхового случая,
                    уведомить об этом страховщика (устно, письменно). Сообщение в устной форме должно быть в последующем
                    подтверждено письменно.</p>
                <strong>48. Застрахованный обязан:</strong>
                <p>1) принять меры к уменьшению убытков от страхового случая;</p>
                <p>2) при наступлении страхового случая незамедлительно лично или через представителя уведомить о
                    произошедшем ассистанс компанию любым из доступных способов связи, указанных в страховом
                    сертификате, сообщить данные о страховом сертификате и (или) страховом полисе ассистанс компании с
                    целью организации технической, медицинской и иной помощи, согласования действий и осуществления
                    расходов;</p>
                <p>3) при наступлении страхового случая выполнять рекомендации, указания ассистанс компании, страховщика
                    и иных компетентных лиц, органов власти страны (места) временного пребывания;</p>
                <p>4) представить страховщику имеющиеся документы, необходимые для выяснения обстоятельств о характере и
                    размерах причиненного вреда страховым случаем;</p>
                <p>5) при получении медицинской помощи в экстренном случае и невозможности незамедлительного уведомления
                    ассистанс компании по уважительным причинам о наступившем страховом случае известить ассистанс
                    компанию о произошедшем в течение двух суток либо при первой возможности;</p>
                <p>6) представить по запросу страховщика документы на иностранном языке с нотариально заверенным их
                    переводом на казахский или русский язык.</p>
            </td>
        </tr>
        <tr valign="top">
            <td>
                <strong>Порядок и условия осуществления страховых выплат</strong>
            </td>
            <td>
                <p>53. Размер страховой выплаты определяется страховщиком исходя из суммы фактических расходов
                    застрахованного на основании документов, подтверждающих эти расходы, представленных застрахованным
                    либо ассистанс компанией.</p>
                <p>54. Выгодоприобретателем является лицо, определенное застрахованным, а в случае гибели
                    застрахованного - его наследники.</p>
                <p>55. Требование о страховой выплате за вред, причиненный в период действия договора обязательного
                    страхования туриста, может быть предъявлено страховщику в течение трех лет с момента наступления
                    страхового случая.</p>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <p>Полные условия Правил на сайте <a href="https://amanat24.kz/ru/insurance-rules">https://amanat24.kz/ru/insurance-rules</a></p>
    <br/><br/>
</div>
</body>
</html>',
            ],
            [
                'code'     => 'sms-ost-mst',
                'theme_ru' => 'Уведомление о выписке ОСТ + МСТ',
                'body_ru'  => 'Здравствуйте, {{ $args["full_name"] }}.' . PHP_EOL . 'Полис ОСТ {{ $args["certificate_number"] }} (ЕСБД {{ $args["global_id"] }}).' . PHP_EOL .
                    '@if(isset($args["certificate_number_mst"]))МСТ {{ $args["certificate_number_mst"] }}.' . PHP_EOL . '@endif https://my.amanat24.kz',
            ],
            [
                'code'     => 'email-osgpovts',
                'theme_ru' => 'УВЕДОМЛЕНИЕ/ХАБАРЛАМА [{{ $args["created_at"] }}]',
                'body_ru'  => '<p>@if($args["is_natural_person"])Уважаемый(ая) {{ $args["full_name"] }}@else{{ $args["full_name"] }}@endif,<br />
                Рады видеть вас в числе клиентов АО «Страховая компания «Amanat»!<br />
                <b>Уникальный номер вашего договора страхования - {{ $args["global_id"] }}.</b><br />
                Благодарим за выбор!<br /><br />
                @if($args["is_natural_person"])Құрметті {{ $args["full_name"] }}@else{{ $args["full_name"] }}@endif,<br />
                «Amanat» сақтандыру компаниясы» АҚ тұтынушыларының қатарына қосылуыңызды көруге қуаныштымыз!<br />
                <b>Сіздің сақтандыру шартыңыздың бірегей нөмірі - {{ $args["global_id"] }}.</b><br />
                Бізді таңдағаныңызға алғыс білдіреміз!</p><br /><br />
                <table cellspacing="0" style="border-collapse:collapse; border: none;">
                    <tbody>
                        <tr>
                            <td style="width:267.05pt">
                            <p>Ваш Amanat<br />
                            пр. Достык, 232, Алматы, Казахстан<br />
                            Call Center + 7 727 244 33 44<br />
                            7310</p>
                            </td>
                            <td style="width:267.05pt">
                            <p>Әрдайым Сіздің Amanat<br />
                            Достық данғылы, 232, Алматы, Қазақстан<br />
                            Call Center + 7 727 244 33 44<br />
                            7310</p>
                            </td>
                        </tr>
                    </tbody>
                </table>',
            ],
            [
                'code'     => 'sms-osgpovts',
                'theme_ru' => 'Уведомление о выписке ОС ГПО ВТС',
                'body_ru'  => 'Страхователь: {{ $args["full_name"] }}'
                    . PHP_EOL . 'Срок действия: {{ $args["date_begin"] }} г. - {{ $args["date_end"] }} г.'
                    . PHP_EOL . 'Рег.номер ТС: {{ $args["reg_numbers"] }}.'
                    . PHP_EOL . 'Номер полиса: {{ $args["global_id"] }}.'
                    . PHP_EOL . 'Amanat в соцсетях:'. PHP_EOL . 'http://bit.ly/amnt-ig'. PHP_EOL . 'https://bit.ly/amnt-fb',
            ],
            [
                'code'     => 'email-shanyrak',
                'theme_ru' => 'УВЕДОМЛЕНИЕ/ХАБАРЛАМА [{{ $args["created_at"] }}]',
                'body_ru'  => '<p>@if($args["is_natural_person"])Уважаемый(ая) {{ $args["full_name"] }}@else{{ $args["full_name"] }}@endif,<br />
                Рады видеть вас в числе клиентов АО «Страховая компания «Amanat»!<br />
                <b>Уникальный номер вашего договора страхования - {{ $args["global_id"] }}.</b><br />
                Для просмотра уведомления скачайте файл, вложенный в письмо.<br />
                Благодарим за выбор!<br /><br />
                @if($args["is_natural_person"])Құрметті {{ $args["full_name"] }}@else{{ $args["full_name"] }}@endif,<br />
                «Amanat» сақтандыру компаниясы» АҚ тұтынушыларының қатарына қосылуыңызды көруге қуаныштымыз!<br />
                <b>Сіздің сақтандыру шартыңыздың бірегей нөмірі - {{ $args["global_id"] }}.</b><br />
                Хабарландыруды көру үшін, хатқа салынған файлды жүктеңіз.
                Бізді таңдағаныңызға алғыс білдіреміз!</p><br /><br />
                <table cellspacing="0" style="border-collapse:collapse; border: none;">
                    <tbody>
                        <tr>
                            <td style="width:267.05pt">
                            <p>Ваш Amanat<br />
                            пр. Достык, 232, Алматы, Казахстан<br />
                            Call Center + 7 727 244 33 44<br />
                            7310</p>
                            </td>
                            <td style="width:267.05pt">
                            <p>Әрдайым Сіздің Amanat<br />
                            Достық данғылы, 232, Алматы, Қазақстан<br />
                            Call Center + 7 727 244 33 44<br />
                            7310</p>
                            </td>
                        </tr>
                    </tbody>
                </table>',
            ],
            [
                'code'     => 'sms-shanyrak',
                'theme_ru' => 'Уведомление о выписке Шанырак',
                'body_ru'  => 'Страхователь: {{ $args["full_name"] }}'
                    . PHP_EOL . 'Срок действия: {{ $args["date_begin"] }} г. - {{ $args["date_end"] }} г.'
                    . PHP_EOL . 'Номер полиса: {{ $args["global_id"] }}.'
                    . PHP_EOL . 'Amanat в соцсетях:'. PHP_EOL . 'http://bit.ly/amnt-ig'. PHP_EOL . 'https://bit.ly/amnt-fb',
            ],
            [
                'code'     => 'sms-verification-code',
                'theme_ru' => 'Код подтверждения',
                'body_ru'  => 'Код подтверждения: {{ $args["code"] }}.',
            ],
            [
                'code'     => 'sms-free-text',
                'theme_ru' => 'Свободное сообщение',
                'body_ru'  => '{{ $args["text"] }}',
            ],
            [
                'code' => 'email-kasko',
                'theme_ru' => 'УВЕДОМЛЕНИЕ/ХАБАРЛАМА [{{ $args["created_at"] }}]',
                'body_ru' => '<html>
                                <head>
                                    <title>СТРАХОВОЙ СЕРТИФИКАТ КАСКО</title>
                                    <style>
                                        * {
                                            box-sizing: border-box;
                                            -moz-box-sizing: border-box;
                                            padding: 0;
                                            margin: 0;
                                        }

                                        .page-contract {
                                            position: relative;
                                            display: block;
                                            width: 200mm;
                                            height: 209mm;
                                        }

                                        table {
                                            font-size: 12px;
                                            margin: 0 0 2mm 0;
                                            width: 100%;
                                            border-collapse: collapse;
                                        }

                                        td, th {
                                            border: 1px solid #000;
                                            padding: 1.4mm;
                                        }

                                    </style>
                                </head>
                                <body>
                                <div class="page-contract">
                                    <p>Здравствуйте, {{ $args["full_name"] }}!<br/>Рады видеть Вас в числе клиентов АО &laquo;Страховая компания &laquo;Amanat&raquo;<br/><br/>Уведомляем
                                        о заключении договора КАСКО</p>

                                </div>
                                </body>
                                </html>'
            ]
        ];

        foreach ($templates as $value) {
            $template = NotificationTemplate::where(['code' => $value['code']])->first();
            if ($template) {
                $template->update($value);
            }else{
                NotificationTemplate::create($value);
            }
        }
    }
}
