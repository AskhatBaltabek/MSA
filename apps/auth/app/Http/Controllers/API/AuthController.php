<?php

namespace App\Http\Controllers\API;

use Adldap\Laravel\Facades\Adldap;
use App\Http\Requests\LoginRequest;
use App\Models\ActiveDirectory\LdapUser;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AuthController extends BaseController
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $login = str_replace('@a-i.kz', '', $request->login);
        $user = User::findBy('login', $login);

        if ($user) {
            if ($user->external) {
                if (!$token = Auth::attempt(['login' => $login, 'password' => $request->password])) {
                    return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
                }

                $success['access_token'] = $token;
                $success['token_type'] = 'bearer';
                $success['expires_in'] = auth()->factory()->getTTL() * 60;
                $success['user'] = $user;
                $success['ldap'] = 0;

                $this->saveUserDataToRedis($user);
                return $this->sendResponse($success, 'User login successfully.');
            }
        }

        try {
            $authenticated = Adldap::auth()->attempt($login, $request->password);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        if ($authenticated) {
            return $this->authByLdap($request, $user);
        }
        else return $this->unauthorized();
    }


    public function authByLdap(LoginRequest $request, $user): JsonResponse
    {
        $login = str_replace('@a-i.kz', '', $request->login);
        $ldapUser = (new LdapUser($login))->getUser()->getAttributes();
        $ldapUser['password'] = Hash::make($request->password);

        if (!$user) {
            $user = new User;
            $user->createUserFromLdap($ldapUser);
            $user = User::findBy('login', $login);
        } else {
            $user = User::findBy('login', $login);
            $user->updateUserFromLdap($ldapUser);
        }

        if (!$token = Auth::attempt(['login' => $login, 'password' => $request->password])) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $success['access_token'] = $token;
        $success['token_type'] = 'bearer';
        $success['expires_in'] = auth()->factory()->getTTL() * 60;
        $success['user'] = $user;
        $success['ldap'] = 1;

        $this->saveUserDataToRedis($user);
        return $this->sendResponse($success, 'User login successfully.');
    }

    public function saveUserDataToRedis($user)
    {
        $id = $user->id;
        $redis = Redis::connection();
        $redis->set('users' . $id, json_encode($user));
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
