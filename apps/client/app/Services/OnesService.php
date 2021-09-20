<?php


namespace App\Services;

use App\Traits\ApiClient;
use GuzzleHttp\Client;

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

    public function getClient($data)
    {
        $params = ['query' => [
            'methodName' => 'getClient',
            'params' => [
                'ClientType' => $data['natural_person_bool'] ?? 1,
                'IIN' => $data['iin'] ?? '',
            ]
        ]];

        $res = $this->get('api/v2/ones/call-method', $params);
        if(isset($res->success) AND $res->success) {
            return $res->data;
        }
        return $res;
    }
}
