<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Session;

trait ApiClient
{
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [], $json = FALSE)
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);
        if (empty($headers)) {
            $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        }

        if (isset($this->secret)) {
            $headers['Authorization'] = 'Bearer ' . $this->secret;
        }

        try {
            $response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
            if ($json) return json_decode($response->getBody()->getContents());
            else return $response->getBody()->getContents();
        } catch (RequestException $e) {
            $error = json_decode($e->getResponse()->getBody());
            return ['error' => $error];
        }

    }
}
