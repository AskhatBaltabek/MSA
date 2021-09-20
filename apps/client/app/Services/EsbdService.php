<?php


namespace App\Services;

use App\Models\EsbdClient;
use App\Traits\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EsbdService
{
    use ApiClient;

    public $baseUri;
    private $login;
    private $password;
    public $headers;

    /**
     * Variable store instance object of GuzzleHttp
     *
     * @var client
     */
    private $client;

    /**
     * Create instance new object.
     *
     */
    public function __construct()
    {
        $this->baseUri = env('ESBD_SERVICE_URL');
        $this->headers = ['Content-Type' => 'application/json'];
    }

    public function getClient($data)
    {
        $params = ['query' => [
            'methodName' => 'GetClientsByKeyFields',
            'params'     => [
                'aClient' => [
                    'ID'                    => '',
                    'Class_ID'              => '',
                    'Born'                  => $data['born'] ?? '',
                    'Sex_ID'                => '',
                    'SETTLEMENT_ID'         => '',
                    'DOCUMENT_TYPE_ID'      => '',
                    'DOCUMENT_NUMBER'       => '',
                    'ACTIVITY_KIND_ID'      => 250,
                    'ECONOMICS_SECTOR_ID'   => 10,
                    'SIC'                   => '',
                    'verify_bool'           => 0,
                    'COUNTRY_ID'            => $data['country_id'] ?? 0,
                    'VERIFY_TYPE_ID'        => '',
                    'IIN'                   => $data['iin'] ?? '',
                    'Natural_Person_Bool'   => $data['natural_person_bool'] ?? 1,
                    'RESIDENT_BOOL'         => $data['resident_bool'] ?? 1,
                    'First_Name'            => $data['first_name'] ?? '',
                    'Last_Name'             => $data['last_name'] ?? '',
                    'Middle_Name'           => $data['middle_name'] ?? '',
                    'Juridical_Person_Name' => $data['juridical_person_name'] ?? '',
                ]
            ]
        ]];

        $response = $this->get('api/call-method', $params);

        if (!empty($response->success)) {
            // Если клиент найден, то для удобства переводим ключи объекта в нижний регистр
            if (!empty($response->data->GetClientsByKeyFieldsResult)) {
                $clientData = $response->data->GetClientsByKeyFieldsResult->Client;

                // Если ЕСБД вернул несколько клиентов то берем первую
                if (is_array($clientData)) {
                    $clientData = $clientData[0];
                }

                if (isset($clientData->Natural_Person_Bool) && $clientData->Natural_Person_Bool) {
                    $clientData->Class_ID = $this->getClassId($clientData->ID);
                    $clientData->Class    = $this->getClassText($clientData->Class_ID);
                }

                $response->data = array_change_key_case((array)$clientData, CASE_LOWER);
            } else {
                $response->data = [];
            }
        }

        return $response;
    }

    /**
     * @throws GuzzleException
     */
    public function setClient($data)
    {
        $client = new EsbdClient($data);

        $params = [
            'query' => [
                'methodName' => 'SetClient',
                'params'     => [
                    'aClient' => (array)$client
                ]
            ]
        ];

        return $this->get('api/call-method', $params);
    }

    /**
     * @throws GuzzleException
     */
    public function exchangeClient($data)
    {
        $res = $this->getClient($data);

        if (isset($res->success) and $res->success) {
            $res = $res->data->GetClientsByKeyFieldsResult;
            if ($res) {
                return $res->Client;
            } else {
                $res = $this->setClient($data);
                if (isset($res->success) and $res->success) {
                    return $res->data->SetClientResult;
                }
            }
        }
        return $res;
    }

    public function getClassId($clientId)
    {
        $response = $this->get('api/call-method', [
            'query' => [
                'methodName' => 'GetClassId',
                'params'     => [
                    'aClientId' => $clientId,
                    'aDate'     => '',
                    'aTFId'     => ''
                ]
            ]
        ]);

        if (! empty($response->success)) {
            return $response->data->GetClassIdResult;
        }

        return 0;
    }

    public function getClassText($classId)
    {
        $response = $this->get('api/call-method', [
            'query' => [
                'methodName' => 'GetClassText',
                'params'     => [
                    'aClassId' => $classId
                ]
            ]
        ]);

        if (! empty($response->success)) {
            return $response->data->GetClassTextResult;
        }

        return '';
    }
}
