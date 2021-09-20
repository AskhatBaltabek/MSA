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

    /**
     * @throws GuzzleException
     */
    public function getCar($data)
    {
        $params = [
            'query' => [
                'methodName' => 'SearchVehicles',
                'params' => [
                    'aTF_NUMBER' => $data['number'],
                    'aTF_ID' => 0
                ]
            ]
        ];
        $res = $this->get('api/call-method', $params);

        if (isset($res->success) and $res->success and isset($res->data)) {
            return $res->data->SearchVehiclesResult->Vehicle;
        }
        return [];
    }


}
