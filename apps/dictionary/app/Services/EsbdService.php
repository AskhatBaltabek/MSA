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

    private function __construct()
    {
        $this->certPath = storage_path(env('ESBD_CERT'));

        if (!is_file($this->certPath)) {
            die('Certificate not found by specified path!');
        }

        $this->aName     = env('ESBD_LOGIN');
        $this->aPassword = env('ESBD_PASSWORD');
        $this->esbdHost  = env('ESBD_HOST');
        if (!$this->aName || !$this->aPassword) {
            die('Requisites for ESBD connection required!');
        }
    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
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
                'cache_wsdl'     => WSDL_CACHE_NONE, // "connection_timeout" => 10,
                'stream_context' => $streamContext,
            ]);

        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return true;
    }

    private function _getEsbdData($method_name, $arData = array(), $is_request = 0, $returnArray = 1)
    {
        if (!$this->_connectToEsbd()) return false;
        // упаковка запроса в поле 'request'
        if ($is_request) $arRequest['request'] = $arData; else $arRequest = $arData;
        $obj = null;
        try {
            $obj = $this->SOAP_CLIENT->$method_name($arRequest);

        } catch (\Exception $ex) {
            $this->arMSG['str'] = $ex->getMessage();
        }
        if (!$obj) {
            $errorText = self::getInstance()->arMSG['str'];
            return TextHelper::parseEsbdError($errorText);
        }
        if ($obj) {
            return $returnArray ? ConverterHelper::parseObj2Arr($obj) : $obj;
        }

        return false;
    }

    protected function getSessionId()
    {
        if (!$this->SESSION_ID) {
            $arRequest        = array(
                'aName'     => $this->aName,
                'aPassword' => $this->aPassword,
            );
            $res              = $this->_getEsbdData('AuthenticateUser', $arRequest);
            $id               = $res['AuthenticateUserResult']['SessionID'];
            $this->SESSION_ID = $id;
        }
        return $this->SESSION_ID;
    }

    /**
     * Метод получения элементов справочника с ЕСБД
     * @param $table_name
     * @return array|false|mixed|string
     */
    public static function getItems($table_name)
    {
        return self::getInstance()->_getEsbdData('GetItems', array(
            'aSessionID' => self::getInstance()->getSessionId(),
            'aTableName' => $table_name
        ));

    }

    /**
     * @param string $methodName
     * @param array $params
     * @return array|false|mixed|string
     */
    public static function callMethod($methodName, $params)
    {
        $params['aSessionID'] = self::getInstance()->getSessionId();
        return self::getInstance()->_getEsbdData($methodName, $params);
    }

}
