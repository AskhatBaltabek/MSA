<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class BaseController
 * @package App\Http\Controllers\Api
 */
class BaseController extends Controller
{
    /**
     * response method
     *
     * @param $messages
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendResponseSuccess($message, $data = [], $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success'  => true,
            'messages' => $message,
            'data'     => $data
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * response method
     *
     * @param $errors
     * @param $messages
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendResponseError($message = '', $errors = [], $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors'  => $errors
        ];

        return response()->json($response, $statusCode);
    }
}
