<?php


namespace App\Services;


use App\Traits\ApiClient;
use Illuminate\Support\Facades\Session;

class RestService
{
    use ApiClient;

    public $baseUri;
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.rest.base_uri');
        $this->secret = request()->bearerToken();
    }

    public function obtainItems($table_name)
    {
        return $this->performRequest('GET', "/api/get-dictionary-items/{$table_name}");
    }
}
