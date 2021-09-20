<?php


namespace App\Services;

use App\Traits\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DictionaryService
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
     * @param null $uri
     */
    public function __construct($uri = NULL)
    {
        $this->baseUri = $uri ?? env('DICT_SERVICE_BASE_URI');
    }

    /**
     * Получение шаблонов документов
     * @param $key
     * @param string $lang
     * @return string
     */
    public function getContract($key, $lang = 'ru'): string
    {
        try {
            $template = $this->get('api/print-templates/key/' . $key);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $template->{'body_' . $lang};
    }

    /**
     * Получение списка стран
     * @param $key
     * @return string
     */
    public function getCountries($key = 0): string
    {
        try {
            if ($key > 0) {
                $request = $this->get('api/countries/country_id/' . $key);
            } else {
                $request = $this->get('api/countries');
            }
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return $request;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getGovVerify()
    {
        $verify = $this->get('api/settings/key/verify_bool');

        return json_decode($verify->setting)->value;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getActiveMkbUrl()
    {
        $setting = $this->get('api/settings/key/mkb_urls');
        foreach(json_decode($setting->setting) as $url) {
            if($url->active == 1) {
                return $url->url;
            }
        }

        return false;
    }

}
