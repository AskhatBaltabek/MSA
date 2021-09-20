<?php

namespace App\Http\Requests;

use App\Http\Controllers\BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Http\FormRequest;

class OnesRequest extends FormRequest
{
    protected Client $client;

    const PRODUCTS_URL = '/GetInsuranceProducts';
    const RISKS_URL = '/GetRisks';
    const INSURANCE_OBJECTS_URL = '/GetObjects';
    const INSURANCE_TYPES_URL = '/GetTypeObjects';

    /* parameter is ID=your_id */
    const PRODUCT_BY_ID_URL = '/GetInsuranceProductByID';
    const RISK_BY_ID_URL = '/GetRiskByID';
    const INSURANCE_OBJECT_BY_ID_URL = '/GetObjectByID';
    const INSURANCE_TYPE_BY_ID_URL = '/GetTypeObjectByID';

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json',],
            'auth' => [env('ONES_USERNAME'), env('ONES_PASSWORD')],
            'verify' => FALSE,
            'cu'
        ]);
    }

   public function getRisks()
   {
       try {
           $request = $this->client->get(env('ONES_URL').self::RISKS_URL);
           $response = $request->getBody();
           return json_decode($response)->Risks;
       } catch (GuzzleException $e) {
           return (new BaseController)->sendError($e->getMessage(), [], $e->getCode());
       }
   }

   public function getProducts()
   {
       try {
           $request = $this->client->get(env('ONES_URL').self::PRODUCTS_URL);
           $response = $request->getBody();
           return json_decode($response)->Products;
       } catch (GuzzleException $e) {
           return (new BaseController)->sendError($e->getMessage(), []);
       }
   }

    public function getInsuranceObjects()
    {
        try {
            $request = $this->client->get(env('ONES_URL').self::INSURANCE_OBJECTS_URL);
            $response = $request->getBody();
            return json_decode($response)->Objects;
        } catch (GuzzleException $e) {
            return (new BaseController)->sendError($e->getMessage(), []);
        }
    }

    public function getInsuranceTypes()
    {
        try {
            $request = $this->client->get(env('ONES_URL').self::INSURANCE_TYPES_URL);
            $response = $request->getBody();
            return json_decode($response)->Types;
        } catch (GuzzleException $e) {
            return (new BaseController)->sendError($e->getMessage(), []);
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
