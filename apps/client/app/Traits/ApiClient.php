<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

trait ApiClient
{
    /**
     * @param $method
     * @param $requestUrl
     * @param array $params
     * @param bool $json
     * @return array|string
     * @throws GuzzleException
     */
    public function request($method, $requestUrl, $params = [], $json = FALSE)
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUri
            ]);
        }catch (\Exception $e){
            return ['error' => $e->getMessage()];
        }

        if (!array_key_exists('headers', $params)) {
            $params['headers'] = ['Content-type' => 'application/x-www-form-urlencoded'];
        }

        if (isset($this->login) && isset($this->password)) {
            $params['auth'] = [$this->login, $this->password];
        }
        else if (isset($this->secret)) {
            $params['headers']['Authorization'] = 'Bearer ' . $this->secret;
        }

        if (isset($this->login) && isset($this->password)) {
            $params['auth'] = [$this->login, $this->password];
        }
        else if (isset($this->secret)) {
            $params['headers']['Authorization'] = 'Bearer ' . $this->secret;
        }
        try {
            $response = $client->request($method, $requestUrl, $params);
            if ($json) return json_decode($response->getBody()->getContents());
            else return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody());
        }
    }

    /**
     * @param $url
     * @param array $params
     * @param bool $json
     * @return Exception[]|RequestException[]|mixed|string
     * @throws GuzzleException
     */
    public function get($url, $params = [], $json = TRUE)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
            'verify' => FALSE,
            'cu'
        ]);

        if (!array_key_exists('headers', $params)) {
            $params['headers'] = ['Content-type' => 'application/json'];
        }

        if (isset($this->login) && isset($this->password)) {
            $params['auth'] = [$this->login, $this->password];
        }
        else if (isset($this->secret)) {
            $params['headers']['Authorization'] = 'Bearer ' . $this->secret;
        }

        try {
            $response = $client->get($url, $params);

            if ($json) {
                return json_decode($response->getBody()->getContents());
            }

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody());
        }
    }

    /**
     * @param $url
     * @param null $params
     * @param array $multipart
     * @param bool $json
     * @return mixed
     * @throws GuzzleException
     */
    public function postUrl($url, $params = NULL, $json = true)
    {
        $credentials = [
            'base_uri' => $this->baseUri,
            'verify'   => FALSE,
            'cu'
        ];
        if (isset($this->headers)) {
            $credentials['headers'] = $this->headers;
        }

        if (isset($this->login) && isset($this->password)) {
            $credentials['auth'] = [$this->login, $this->password];
        }
        else if (isset($this->secret)) {
            $credentials['headers']['Authorization'] = 'Bearer ' . $this->secret;
        }

        $client = new Client($credentials);

        try {
            $request = $client->post($url, ['form_params' => $params]);

            $response = json_decode($request->getBody(), true);

            if ($json == true) {
                $result = $this->sendResponseSuccess('Данные получены', $response, $request->getStatusCode());
            } else {
                $result['data'] = $response;
                $result['success'] = true;
            }

            return $result;
        } catch (RequestException $e) {
            $response = json_decode($e->getResponse()->getBody(), true);

            if ($json == true) {
                $result = $this->sendResponseError('Ошибка при получении данных', $response['errors'] ?? ['message' => [$response['message']]]);
            } else {
                $result = $response;
                $result['errors'] = $response['errors'] ?? $response;
                $result['success'] = false;
            }

            return $result;

        }
    }
}
