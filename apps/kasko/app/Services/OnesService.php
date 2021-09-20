<?php


namespace App\Services;

use App\Repositories\OnesPolicyRepository;
use App\Traits\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OnesService
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
        $this->baseUri = env('ONES_SERVICE_URL');
        $this->headers = ['Content-Type' => 'application/json'];
    }

    /**
     * @throws GuzzleException
     */
    public function setPolicy($data)
    {
        $policyData                  = clone $data;
        $product                     = (new DictionaryService)->get('api/products/code/' . $policyData['product_code']);
        $policyData['policy_number'] = $this->getNumberGeneration(['InsProduct' => $product->id_1c, 'ManagerId' => $policyData->manager_id_1c])->return->message;
        $policyData['product_id_1c'] = $product->id_1c;
        // Формируем структуру для отправки в 1С
        $onesPolicy          = (new OnesPolicyRepository($policyData));
        $onesPolicyStructure = (array)$onesPolicy;
        unset($onesPolicyStructure['policy']);

        // Сохраняем календарь платежей
        $payments = $data->payments;
        if ($payments['payment_type'] == 1) {
            $payments['payment_schedule'] = $onesPolicyStructure['PaymentSchedule'];
        }
        $data->payments = $payments;

        $params = [
            'form_params' => [
                'methodName' => 'setPolicy',
                'params'     => $onesPolicyStructure
            ],
        ];

        return $this->post('api/v2/ones/call-method', $params, false);
    }

    public function setPolicyRescindingReason($policyNumber, $reasonId)
    {
        $params = [
            'form_params' => [
                'methodName' => 'SetPolicyRescindingReason',
                'params'     => [
                    "NumPolicy"          => $policyNumber,
                    "RescindingReasonId" => $reasonId
                ]
            ]
        ];

        return $this->post('api/v2/ones/call-method', $params, false);
    }


    /**
     * @throws GuzzleException
     */
    public function getNumberGeneration($data = [])
    {
        $params = [
            'query' => [
                'methodName' => 'getNumberGeneration',
                'params'     => $data
            ]
        ];

        return $this->get('api/v1/ones/call-method', $params);
    }

}
