<?php


namespace App\Services;


use App\Traits\ConsumesExternalServices;
use Illuminate\Support\Facades\Session;

class RestService
{
    use ConsumesExternalServices;

    public $baseUri;
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.rest.base_uri');
        $this->secret = request()->bearerToken();
    }

    public function obtainCar($data)
    {
        return $this->performRequest('GET', "/api/partner/get-car?{$data}");
    }
}
