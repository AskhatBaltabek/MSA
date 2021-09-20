<?php
namespace App\Guard;
use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Predis\Client;
use Tymon\JWTAuth\JWT;
class JWTGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var JWT $jwt
     */
    protected JWT $jwt;

    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * JWTGuard constructor.
     * @param JWT $jwt
     * @param Request $request
     */
    public function __construct(JWT $jwt, Request $request) {
        $this->jwt = $jwt;
        $this->request = $request;
    }

    public function user() {
        if (!is_null($this->user)) {
            return $this->user;
        }
        if ($this->jwt->setRequest($this->request)->getToken() && $this->jwt->check()) {
            $id = $this->jwt->payload()->get('sub');
            $this->user = new User();
            $this->user->id = $id;

            $this->setUserAttributesFromRedis($this->user);

            return $this->user;
        }
        return null;
    }

    public function validate(array $credentials = []) {
    }

    public function setUserAttributesFromRedis(User $user){
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
        $response = $redis->get('users'.$user->id);
        $attributes = json_decode($response, true);
        if($attributes){
            foreach ($attributes as $key => $value){
                $user->$key = $value;
            }
        }
    }
}
