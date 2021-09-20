<?php


namespace App\Services;

use http\Exception;

class KolesaService
{
    private static $_instance = null;
    private $_isActive = TRUE;
    private $host_analytics = 'https://kolesa.kz/analytics/?';
    private $host_parser = 'https://kolesa.kz/a/ajax-get-value-parameter/?';

    const ID = 120217951;
    const ANALYTICS = 1;
    const PARSER = 2;

    private function __construct()
    {

    }

    private static function _getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $type
     * @param $data
     * @return array|\Exception|Exception
     */
    public function _request($data, $type = 1)
    {
        $response = ['status' => FALSE, 'message' => ''];
        if (!$this->_isActive) {
            $response['message'] = 'Сервис отключен!';
            return $response;
        }

        $data .= '&id=' . self::ID;

        $host = $type == self::ANALYTICS ? $this->host_analytics : $this->host_parser;
        try {
            $ch = curl_init($host . $data);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, 'https://google.com');
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; ry:38.0) Gecko/20100101 Firefox/38.0");
            curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-requested-with:XMLHttpRequest", "cache-control:no-cache",]);

            $result = curl_exec($ch);
            $result = json_decode($result);
        } catch (Exception $exception) {
            return $exception;
        }
        return $result;
    }

    /**
     * @param $data
     * @return array
     */
    public static function GetCarPricing($data): array
    {
        unset($data['is_bu']);
        $array = [];
        $data = http_build_query($data);

        $response = self::_getInstance()->_request($data, 1);

        if(isset($response->data) && isset($response->data->avgPrice) && $response->data->avgPrice) {
            $array = [
                'title' => $response->data->title,
                'price' => $response->data->avgPrice,
                'model_alias' => explode('/', $response->data->url)[3] ?? '',
                'mark_alias' => explode('/', $response->data->url)[2] ?? '',
                'nbTotal' => $response->data->histogram->nbTotal
            ];
        }

        return $array;

    }

    /**
     * @return array
     */
    public static function GetMarkParser(): array
    {
        $array = array();

        for ($id = 1; $id < 300; $id++) { // Создаем для парсера ID марка автомобилей
            $data = http_build_query([
                "mark" => $id,  # this is index of a car's mark
                "id" => self::ID,  # this and below are default params
            ]);

            $response = self::_getInstance()->_request($data, 1);

            if (isset($response)) {
                preg_match("~/cars/([^/]*)/~", $response->data->url, $mark);
                preg_match("/cars([^?]*)/", $response->data->url, $model);
                preg_match("([^*,]*) ", $response->data->title, $title);
                $textArray = explode(' ', $title[0]);
                $textForReplace = str_replace(' ' . $textArray[count($textArray) - 1], '', $title)[0];
                if (isset($mark[1])) {
                    $array[] = [
                        'id' => $response->data->mark, // ID марки
                        'title' => $textForReplace, // Название марки
                        'mark_alias' => $mark[1], // Название в латинице
                    ];
                }
            }
        }
        return $array;
    }

}
