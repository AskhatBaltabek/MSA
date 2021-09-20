<?php


namespace App\Services;

use App\Http\Controllers\Api\BaseController;
use App\Traits\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RestService
{
    use ApiClient;

    public $baseUri;
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
        $this->baseUri = config('services.rest.base_uri');
    }

    /**
     * @param string $policy_number
     * @return string
     */
    public function getFileContentFromRepo(string $policy_number): string
    {
        try {
            $base64 = $this->performRequest('GET', "/api/download-file/" . $policy_number);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $base64;
    }
}
