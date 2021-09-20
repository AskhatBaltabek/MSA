<?php


namespace App\Services;


use App\Traits\ApiClient;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthService
{
    use ApiClient;

    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.auth.base_uri');
        $this->secret = request()->bearerToken();
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
        $redis = Redis::connection();
        $redis->set('users' . $id, json_encode($user->data->user));
    }
}
