<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public $authService;

    /**
     * Create a new AuthController instance.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:jwt', ['except' => ['login']]);
        $this->authService = $authService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function login(Request $request)
    {
        $credentials = request(['login', 'password']);
        if ($request->email) {
            $credentials['login'] = $request->email;
            unset($credentials['email']);
        }

        $auth = $this->authService->login($credentials);

        return response()->json($auth);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
