<?php


namespace App\Services;


use App\Traits\ApiClient;
use Predis\Client;

class AuthService
{
    use ApiClient;

    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.auth.base_uri');
    }

    public function login($form_data)
    {
        $auth = $this->performRequest('POST', "/api/login", $form_data, [], true);

        if (is_array($auth) && isset($auth['error'])) {
            return $auth['error'];
        } else if (is_object($auth) && $auth->success == true) {
            $this->saveUserDataToRedis($auth);
            return $auth;
        } else {
            $response['success'] = false;
            $response['message'] = 'Ошибка на стороне Авторизационного сервера!';
            return $response;
        }
    }

    public function saveUserDataToRedis($user){
        $id = $user->data->user->id;
        $parameters = [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ];
        $options = [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', 'laravel_database_'),
        ];
        $redis = new Client($parameters, $options);
        $redis->set('users'.$id, json_encode($user->data->user));
    }
}
