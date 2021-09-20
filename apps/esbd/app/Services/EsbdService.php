<?php


namespace App\Services;

use App\Helpers\ConverterHelper;
use App\Helpers\TextHelper;

class EsbdService
{
    private $certPath;
    private static $_instance = null;
    public $arMSG = [];     // массив-сообщение ('str' => текст_сообщения, 'type' => тип_сообщения (по дефолту: 0 - ошибка)
    private $IS_ACTIVE = 1; // флаг активности сервиса (0 - отключен, 1 - включен)
    private $SOAP_CLIENT;
    private $SESSION_ID;
    private $esbdHost = '';
    private $aName = '';
    private $aPassword = '';

    private function __construct($host = NULL)
    {
        $host = $host ?? (new DictionaryService)->getActiveMkbUrl() ?? env('ESBD_HOST');
        $this->certPath = storage_path(env('ESBD_CERT'));

        if (!is_file($this->certPath)) {
            die('Certificate not found by specified path!');
        }

        $this->aName     = env('ESBD_LOGIN');
        $this->aPassword = env('ESBD_PASSWORD');
        $this->esbdHost  = $host;

        if (!$this->aName || !$this->aPassword) {
            die('Requisites for ESBD connection required!');
        }
    }

    static public function getInstance($host = NULL)
    {
        if (is_null(self::$_instance) || $host) {;
            self::$_instance = new self($host);
        }
        return self::$_instance;
    }

    private function _connectToEsbd()
    {
        if (!$this->IS_ACTIVE) return false;

        $host = $this->esbdHost . '?WSDL';
        try {
            ini_set("default_socket_timeout", 60);
            $streamContext     = stream_context_create([
                'ssl'  => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
                'http' => [
                    'user_agent' => 'PHPSoapClient'
                ]
            ]);
            $this->SOAP_CLIENT = new \SoapClient($host, [
                "exceptions"     => true,
                "local_cert"     => $this->certPath,
                "keep_alive"     => true,
                'trace'          => 1, // Трейсинг нужен для логирования есбд
                //'cache_wsdl'     => WSDL_CACHE_NONE, // "connection_timeout" => 10,
                'stream_context' => $streamContext,
            ]);

        } catch (\Exception $e) {
            return ['error' =>'Сервера ЕСБД на данный момент недоступны. Операцию выполнить невозможно!'];
        }
        return true;
    }

    private function _getEsbdData($method_name, $arData = array(), $is_request = 0, $returnArray = 1)
    {
        $con = $this->_connectToEsbd();
        if (is_string($con) OR $con != TRUE) return $con;

        // упаковка запроса в поле 'request'
        if ($is_request) $arRequest['request'] = $arData; else $arRequest = $arData;
        $obj = null;
        try {
            $obj = $this->SOAP_CLIENT->$method_name($arRequest);
        } catch (\Exception $ex) {
            $this->arMSG['str'] = $ex->getMessage();
            return [
                'message' => TextHelper::parseEsbdError($ex->getMessage()),
                'errors' => [$ex->getMessage()]
            ];
        }

        if ($obj) {
            return ConverterHelper::parseObj2Arr($obj) ?? $obj;
        } else {
            $errorText = self::getInstance()->arMSG['str'];
            return [
                'message' => TextHelper::parseEsbdError($errorText),
                'error' => $errorText
            ];
        }
    }

    protected function getSessionId()
    {
        if (!$this->SESSION_ID) {
            $arRequest        = array(
                'aName'     => $this->aName,
                'aPassword' => $this->aPassword,
            );
            $res              = $this->_getEsbdData('AuthenticateUser', $arRequest);
            if(isset($res['error']) && isset($res['message'])) return $res;
            $id               = $res['AuthenticateUserResult']['SessionID'];
            $this->SESSION_ID = $id;
        }
        return $this->SESSION_ID;
    }

    public static function convertNullToString($params)
    {
        $first_key = key($params);
        if (is_array($params[$first_key])) {
            foreach ($params[$first_key] as $key => $value) {
                if ($value == null) {
                    $params[$first_key][$key] = "";
                }
                $new_param = $params[$first_key][$key];

                if (is_array($new_param)) {
                    $first_key_new_param = key($new_param);
                    foreach ($new_param[$first_key_new_param] as $new_key => $new_value) {
                        if ($new_value == null) {
                            $params[$first_key][$key][0][$new_key] = "";
                        }
                    }
                }
            }
        }

        foreach ($params as $key => $value) {
            if ($value == null) {
                $params[$key] = "";
            }
        }
        return $params;
    }

    /**
     * @param string $methodName
     * @param array $params
     * @return array|false|mixed|string
     */
    public static function callMethod($methodName, $params)
    {
        $params = self::convertNullToString($params);
        $params['aSessionID'] = self::getInstance()->getSessionId();
        $result = self::getInstance()->_getEsbdData($methodName, $params);
        return $result;
    }
}
