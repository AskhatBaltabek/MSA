<?php

namespace App\Repositories;

use App\Helpers\LogicalHelper;
use App\Helpers\TextHelper;
use App\Models\Franchise;
use App\Services\DictionaryService;
use GuzzleHttp\Exception\GuzzleException;

class OnesPolicyRepository
{
    public $policy;

    public $IdPolicyExt;
    public $GlobalId;
    public $Region_id;
    public $NumPolicy;
    public $PrlNumPolicy;
    public $BSO;
    public $InsurancePeriod;
    public $DateCreate;
    public $DateBegin;
    public $DateEnd;
    public $AgentId;
    public $ManagerId;
    public $WithoutAgentComission;
    public $AgentComission;
    public $ProjectBonus;
    public $PaymentForm;
    public $PaymentType;
    public $Premium;
    public $RealPremium;
    public $Currency;
    public $InsProduct;
    public $Territory;
    public $PolicyType;
    public $MainPolicyId;
    public $MainNumPolicy;
    public $Comments;
    public $EntryIntoForce;
    public $Id_sales;
    public $Id_detailing;
    public $Clients;
    public $Vehicles;
    public $InsObjects;
    public $ObjectsInsTypesRisks;
    public $PersonName;
    public $PersonPhone;
    public $PersonEmail;
    public $IdInfSystem;
    public $Beneficiarys;
    public $Verify_bool;
    public $PaymentSchedule;
    public $Options;
    public $SubAgentID;
    public $Country_list;

    /**
     * OnesPolicyRepository constructor.
     * @param $data
     * @throws GuzzleException
     */
    public function __construct($data)
    {
        $this->policy = $data;

        if ($data) {
            $this->IdPolicyExt           = 0;
            $this->GlobalId              = 0;
            $this->NumPolicy             = $data->policy_number;
            $this->BSO                   = 0;
            $this->InsurancePeriod       = 12;
            $this->DateBegin             = date('Y-m-d', strtotime($data->start_date));
            $this->DateEnd               = date('Y-m-d', strtotime($data->end_date));
            $this->AgentId               = $data->agent_id_1c ?? 0;
            $this->ManagerId             = $data->manager_id_1c;
            $this->SubAgentID            = 0;
            $this->WithoutAgentComission = 0;
            $this->AgentComission        = $data->options['agent_commission'] * 100;
            $this->AgentComission        = $data->options['agent_commission'] * 100;
            $this->ProjectBonus          = 0;
            $this->PaymentForm           = $data->payments['payment_type'];
            $this->PaymentType           = 1;
            $this->Premium               = $data->premium;
            $this->RealPremium           = 0;
            $this->Currency              = 'KZT';
            $this->InsProduct            = $data->product_id_1c;
            $this->Territory             = '398;417';
            $this->PolicyType            = 'Заключенный';
            $this->MainPolicyId          = 0;
            $this->MainNumPolicy         = 0;
            $this->Comments              = 'ADP полис';
            $this->EntryIntoForce        = 0;
            $this->Id_sales              = $data->sales_channel_id_1c ?: 1;
            $this->Id_detailing          = $data->detailing_id_1c ?: 10;
            $this->Clients               = $this->getClients($data);
            $this->Vehicles              = $this->getVehicles($data);
            $this->InsObjects            = "";
            $this->ObjectsInsTypesRisks  = $this->getRisks($data);
            $this->Verify_bool           = 0;
            $this->PersonName            = "";
            $this->PersonPhone           = "";
            $this->PersonEmail           = "";
            $this->Region_id             = 0;
            $this->PrlNumPolicy          = 0;
            $this->DateCreate            = date('Y-m-d\TH:i:s');
            $this->IdInfSystem           = 3;
            $this->Beneficiarys          = $this->getBeneficiaries($data);
            $this->PaymentSchedule       = $this->getPaymentSchedule($data);
            $this->Country_list          = [
                [
                    "country_id"     => 1,
                    "country_code"   => 398,
                    "InsObjectKeyID" => "603216b6376634399f000004"
                ],
                [
                    "country_id"     => 9,
                    "country_code"   => 417,
                    "InsObjectKeyID" => "603216b6376634399f000004"
                ]
            ];
            $this->Options               = [
                [
                    'Name'     => "CalcId",
                    'TypeName' => "Число",
                    'Value'    => 1608
                ],
                [
                    'Name'     => "NumberOfDrivers",
                    'TypeName' => "Число",
                    'Value'    => 1
                ],
                [
                    'Name'     => "ВызовГАИ",
                    'TypeName' => "Булево",
                    'Value'    => $data->product_id_1c == 31 ? 1 : 0,
                ],
                [
                    'Name'     => "СпецСТО",
                    'TypeName' => "Перечисления.УсловияОсуществленияВыплаты",
                    'Value'    => "ФирменноеСТОАвтосалона"
                ]
            ];
        }
    }

    /**
     * @return array[]
     */
    public function getClients($data): array
    {
        $client = $data->client;
        return [
            [
                'IsDriver'                     => 0,
                'ClientIdExt'                  => 17290247,
                'ClientType'                   => 1,
                'ClientForm'                   => 1,
                'FirstName'                    => $client->first_name,
                'LastName'                     => $client->last_name,
                'MiddleName'                   => $client->middle_name ?? '',
                'AccountName'                  => $client->fio,
                'IIN'                          => $client->iin,
                'BirthDate'                    => date('Y-m-d', strtotime($client->born)),
                'Sex'                          => 1,
                'AddressCountryId'             => 1,
                'AddressStreet'                => $client->address,
                'DocType'                      => $client->document_type_id,
                'DocNumber'                    => $client->document_number,
                'DocGivedBy'                   => $client->document_gived_by,
                'DocGivedAt'                   => date('Y-m-d', strtotime($client->document_gived_date)),
                'Email'                        => 0,
                'MobilePhone'                  => $client->phone ?? "",
                'Activity'                     => 0,
                'Residence'                    => 1,
                'EconomicSector'               => 0,
                'IIK'                          => "",
                'BIK'                          => "",
                'SendSMS'                      => 1,
                'Class_ID'                     => 0,
                'EXPERIENCE'                   => 0,
                'DRIVER_CERTIFICATE'           => 0,
                'DRIVER_CERTIFICATE_DATE'      => '0001-01-01',
                'HOUSEHOLD_POSITION'           => 0,
                'AGE_EXPERIENCE_ID'            => 0,
                'PRIVELEGER_BOOL'              => 0,
                'WOW_BOOL'                     => 0,
                'PENSIONER_BOOL'               => 0,
                'INVALID_BOOL'                 => 0,
                'PRIVELEDGER_TYPE'             => 0,
                'PRIVELEDGER_CERTIFICATE'      => 0,
                'WOW_CERTIFICATE'              => 0,
                'PENSIONER_CERTIFICATE'        => 0,
                'INVALID_CERTIFICATE'          => 0,
                'PRIVELEDGER_CERTIFICATE_DATE' => '0001-01-01',
                'WOW_CERTIFICATE_DATE'         => '0001-01-01',
                'PENSIONER_CERTIFICATE_DATE'   => '0001-01-01',
                'INVALID_CERTIFICATE_BEG_DATE' => '0001-01-01',
                'INVALID_CERTIFICATE_END_DATE' => '0001-01-01',
                'IPDL'                         => 0
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getVehicles($data): array
    {
        $car = $data->car;

        return [
            [
                'IdExternal'           => $car->tf_id_esbd ?? 0, // ID ESBD
                'CarType'              => 4,//$car->type ?: 0, // Тип ТС, Легковая – 4,  Грузовая – 6;
                'Year'                 => $car->born,
                'RegNumber'            => $car->number,
                'CertificateNubmer'    => $car->passport_number,
                'CertificateDate'      => date('Y-m-d', strtotime($car->passport_date)),
                'UsageTypeId'          => 'Личное',
                'RegistrationRegionId' => $car->registration_region_id,
                'Vin'                  => $car->vin,
                'Color'                => $car->color,
                'Brand'                => $car->mark,
                'Model'                => $car->model,
                'InsObjectKeyID'       => TextHelper::createObjectId(),
                'CountryID'            => 0
            ]
        ];
    }

    /**
     * @param $data
     * @return array
     * @throws GuzzleException
     */
    public function getRisks($data): array
    {
        $dictionaryService = new DictionaryService;

        $tarif = Franchise::find($data->tarif_id_1c);

        $productRelations = array_filter($dictionaryService->get('api/products/id_1c/' . $this->InsProduct . '?with[]=relations')->relations, function ($i) {
            return $i->type_id_1c === 36;
        });

        $result = [];
        foreach ($this->Vehicles as $vehicle) {
            foreach ($productRelations as $rel) {
                $insuranceSum = $data->car->insurance_sum + ($additional->sum ?? 0);
                $res          = [
                    'ObjectTypeID'  => $rel->object_id_1c, //$objectType->id_1c,
                    'InsTypeID'     => $rel->type_id_1c, // Вид страхования
                    'RiskID'        => $rel->risk_id_1c, // Риск
                    'InsObjectID'   => $vehicle['InsObjectKeyID'],
                    'FranchiseType' => 0, //безусловная всегда !!! $kasko->franchise,
                    'Tariff'        => 0,
                    'InsAmount'     => $insuranceSum,
                    'InsAmountMng'  => $insuranceSum,
                    'Premium'       => $data->premium, //$report->sum_final, required
                ];

                if ($rel->risk_id_1c == 86) {
                    $amount                  = $insuranceSum * $tarif->coef_damage;
                    $res['FranchisePercent'] = $tarif->coef_damage * 100;
                    $res['FranchiseAmount']  = LogicalHelper::compare($amount, $tarif->min_sum_damage, $tarif->operator_damage) ? round($tarif->min_sum_damage) : $amount;
                } elseif ($rel->risk_id_1c == 87 || $rel->risk_id_1c == 88) {
                    $res['FranchisePercent'] = $tarif->coef_loss*100;
                    $franchiseDamage = LogicalHelper::compare($insuranceSum * $tarif->coef_damage, $tarif->min_sum_damage, $tarif->operator_damage) ? round($tarif->min_sum_damage) : $insuranceSum * $tarif->coef_damage;
                    $res['FranchiseAmount'] = $franchiseDamage > $insuranceSum * $tarif->coef_loss ? $franchiseDamage : $insuranceSum * $tarif->coef_loss;
                }
                $result[] = $res;
            }
        }

        return $result;
    }

    /**
     * @return array[]
     */
    public function getBeneficiaries($data): array
    {
        $beneficiary = $data->beneficiary;

        $res = [
            'ClientType'  => $beneficiary['natural_person_bool'] ? 1 : 0,
            'ClientForm'  => $beneficiary['client_form'] ?? 1,
            'IIN_BIN'     => $beneficiary['iin'],
            'AccountName' => $beneficiary['name'],
        ];
        return [$res];
    }

    /**
     * @param $data
     * @return array
     */
    public function getPaymentSchedule($data): array
    {
        $payments = $data->payments;
        $res      = [];
        $date     = date('Y-m-d', strtotime($data->start_date . ' + 10 days'));

        if ($payments['payment_type'] == 0) {
            $res[] = [
                'date'    => $date,
                'Payment' => $data->premium
            ];
        } else {
            // Вычисляем баланс на 1 месяц
            $trans   = floor($data->premium / $payments['payment_count']);
            $balance = $data->premium - ($trans * $payments['payment_count']);

            for ($i = 0; $i < $payments['payment_count']; $i++) {
                if ($i > 0) $date = date('Y-m-d', strtotime($date . ' + 1 month'));
                else $date = date('Y-m-d', strtotime($payments['payment_start_date']));

                $res[] = [
                    'date'    => $date,
                    'Payment' => $trans + ($i == 0 ? $balance : 0)
                ];
            }
        }
        return $res;
    }
}
