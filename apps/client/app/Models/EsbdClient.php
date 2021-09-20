<?php

namespace App\Models;

use App\Services\DictionaryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class EsbdClient
{
    public $ID;                    // s:int Идентификатор клиента (обязательно)
    public $Class_ID;
    public $First_Name;            // s:string Имя (для физ. лица)
    public $Middle_Name;           // s:string Отчество (для физ. лица)
    public $Last_Name;             // s:string Фамилия (для физ. лица)
    public $Juridical_Person_Name; // s:string Наименование (для юр. лица)
    public $Juridical_Address;
    public $Natural_Person_Bool;   // s:int Признак принадлежности к физ. лицу (1 - физ. лицо; 0 - юр. лицо)(обязательно)
    public $TPRN;                  // s:string РНН
    public $Born;                  // s:string Дата рождения
    public $Sex_ID;                // s:int Пол (справочник SEX)
    public $SETTLEMENT_ID;         // s:int Населенный пункт (справочник SETTLEMENTS)
    public $Address;               // s:string Адрес
    public $DOCUMENT_TYPE_ID;      // s:int Тип документа (справочник DOCUMENTS_TYPES)
    public $DOCUMENT_NUMBER;       // s:string Номер документа
    public $DOCUMENT_GIVED_BY;     // s:string Документ выдан
    public $DOCUMENT_GIVED_DATE;   // s:string Дата выдачи документа
    public $EMAIL;                 // s:string Адрес электронной почты
    public $WWW;                   // s:string Сайт
    public $PHONES;                // s:string Номера телефонов
    public $MAIN_CHIEF;            // s:string Первый руководитель
    public $MAIN_ACCOUNTANT;       // s:string Главный бухгалтер
    public $ACTIVITY_KIND_ID;      // s:int Вид деятельности (справочник ACTIVITY_KINDS)
    public $DESCRIPTION;           // s:string Примечание
    public $RESIDENT_BOOL;         // s:int Признак резидентства (обязательно)
    public $ECONOMICS_SECTOR_ID;   // s:int Сектор экономики (справочник ECONOMICS_SECTORS)
    public $SIC;                   // s:string СИК
    public $COUNTRY_ID;            // s:int Страна (справочник COUNTRIES)
    public $IIN;                   // s:string ИИН/БИН
    public $BANKS;                 // tns:ArrayOfCLIENTBANK Содержит реквизиты банка клиента.
    public $verify_bool;
    public $VERIFY_TYPE_ID;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct($data = [])
    {
        $verify_bool = (new DictionaryService())->getGovVerify();

        $this->Class_ID            = $data['class_id'] ?? 0;
        $this->ID                  = $data['client_id'] ?? 0;
        $this->First_Name          = $data['first_name'] ?? '';
        $this->Last_Name           = $data['last_name'] ?? '';
        $this->Middle_Name         = $data['middle_name'] ?? '';
        $this->Natural_Person_Bool = $data['natural_person_bool'] ?? 1;
        $this->SETTLEMENT_ID       = 0;
        $this->DOCUMENT_NUMBER     = $data['document_number'] ?? '';
        $this->DOCUMENT_GIVED_BY   = $data['source'] ?? $data['document_gived_by'] ?? '';
        $this->DOCUMENT_GIVED_DATE = $data['document_gived_date'] ? date('d.m.Y', strtotime($data['document_gived_date'])) : '';
        $this->EMAIL               = $data['email'] ?? '';
        $this->WWW                 = '';
        $this->PHONES              = '';
        $this->Address             = $data['address'] ?? '';
        $this->MAIN_CHIEF          = '';
        $this->MAIN_ACCOUNTANT     = '';
        $this->DESCRIPTION         = '';
        $this->RESIDENT_BOOL       = $data['resident_bool'] ?? 1;
        $this->COUNTRY_ID          = $this->RESIDENT_BOOL == 0 && !empty($data['country_id']) ? $data['country_id'] : 1;
        $this->SIC                 = '';
        $this->VERIFY_TYPE_ID      = '';
        $this->IIN                 = $data['iin'] ?? '';
        $this->BANKS               = '';
        $this->verify_bool         = $data['verify_bool'] ?? $verify_bool ??  1;
        $this->Juridical_Person_Name = '';
        $this->Juridical_Address = '';
        $this->Juridical_Address = '';
        $this->Born = $data['born'] ? date('d.m.Y', strtotime($data['born'])) : '';
        $this->TPRN = '';

        if ($this->Natural_Person_Bool == 0) {
            $this->ACTIVITY_KIND_ID      = $data['activity_kind'] ?? 250;
            $this->ECONOMICS_SECTOR_ID   = $data['economics_sector'] ?? 10;
            $this->DOCUMENT_TYPE_ID      = $data['document_type_id'] ?? 1;
            $this->Juridical_Person_Name = $data['juridical_person_name'] ?? '';
            $this->Juridical_Address     = $data['juridical_address'] ?? '';
            $this->Sex_ID                = 0;
            $this->DOCUMENT_NUMBER       = '';
        } else {
            if (isset($data['born'])) {
                if (is_numeric($data['born'])) {
                    $data['born'] = date('d.m.Y', $data['born']);
                }
            }
            $this->ACTIVITY_KIND_ID    = 250;
            $this->ECONOMICS_SECTOR_ID = 10;
            $this->DOCUMENT_TYPE_ID    = $data['document_type_id'] ?? 0;
            $this->Sex_ID              = $data['sex_id'] ?? 0;
        }
    }

}
