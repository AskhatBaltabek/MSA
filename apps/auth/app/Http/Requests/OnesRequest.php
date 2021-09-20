<?php

namespace App\Http\Requests;

use App\Http\Controllers\API\BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Http\FormRequest;

class OnesRequest extends FormRequest
{
    protected Client $client;

    const STAFF_URL = 'GetStaff';
    const AGENTS_URL = 'GetAgentList';
    /* parameter ?login=i.mizin */
    const USER_BY_LOGIN_URL = '/GetEmployee';

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json',],
            'base_uri' => env('ONES_HOST_REST_URL'),
            'auth' => [env('ONES_USERNAME'), env('ONES_PASSWORD')],
            'verify' => FALSE,
            'cu',
        ]);
    }

    public function getData($methodName)
    {
        try {
            $request = $this->client->get($methodName);
            $response = $request->getBody();
            return json_decode($response, true);
        } catch (GuzzleException $e) {
            dd($e);
            return (new BaseController)->sendError(json_decode($e->getResponse()->getBody(), true), [], $e->getCode());
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
