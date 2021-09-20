<?php

namespace App\Services;

use App\Helpers\ConverterHelper;
use App\Helpers\TextHelper;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TheEsbdService
{
    private static $instance;
    private $esbdHost;
    private $certPath;
    private $login;
    private $password;
    private $sessionId;

    /**
     * @params $host
     * @throws \Exception
     */
    private function __construct($host = null)
    {
        $this->esbdHost  = $host ?? (new DictionaryService())->getActiveMkbUrl() ?? env('ESBD_HOST');
        $this->certPath = storage_path(env('ESBD_CERT'));

        if (!is_file($this->certPath)) {
            throw new InternalErrorException('Сертификат не найден по указанному пути!');
        }

        $this->login    = env('ESBD_LOGIN');
        $this->password = env('ESBD_PASSWORD');

        if (!$this->login || !$this->password) {
            throw new InternalErrorException('Требуются реквизиты для подключения ЕСБД!');
        }
    }

    /**
     * @param string $methodName
     * @param array $params
     * @return array|false|mixed|string
     */
    public static function callMethod(string $methodName, array $params)
    {
        // dd('methodName and params', $methodName, $params);
        $params = ConverterHelper::convertNullToString($params);
        $params['aSessionID'] = self::getInstance()->getSessionId();

        return self::getInstance()->getEsbdData($methodName, $params);
    }

    private static function getInstance($host = null)
    {
        if (!self::$instance || $host) {
            self::$instance = new self($host);
        }

        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    private function getEsbdData(string $methodName, array $params = [])
    {
        try {
            $data = $this->connectToEsbd()->$methodName($params);
            $parsed = ConverterHelper::parseObj2Arr($data);

            if (empty($parsed)) {
                throw new NotFoundHttpException();
            }

            return $parsed;
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw new NotFoundHttpException();
            }

            $message = TextHelper::parseEsbdError($e->getMessage());
            throw new InternalErrorException($message);
        }
    }

    /**
     * @throws \Exception
     */
    private function connectToEsbd(): object
    {
        try {
            ini_set("default_socket_timeout", 60);
            $streamContext = stream_context_create([
                'ssl'  => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
                'http' => [
                    'user_agent' => 'PHPSoapClient'
                ]
            ]);

            return new \SoapClient($this->esbdHost . '?WSDL', [
                "exceptions"     => true,
                "local_cert"     => $this->certPath,
                "keep_alive"     => true,
                'trace'          => 1, // Трейсинг нужен для логирования ЕСБД
                // 'cache_wsdl'     => WSDL_CACHE_NONE, // "connection_timeout" => 10,
                'stream_context' => $streamContext,
            ]);
        } catch (\Exception $e) {
            throw new InternalErrorException('Сервера ЕСБД на данный момент недоступны. Операцию выполнить невозможно!');
        }
    }

    private function getSessionId()
    {
        if (!$this->sessionId) {
            $data = $this->getEsbdData('AuthenticateUser', [
                'aName'     => $this->login,
                'aPassword' => $this->password,
            ]);
            $this->sessionId = $data['AuthenticateUserResult']['SessionID'];
        }

        return $this->sessionId;
    }
}
