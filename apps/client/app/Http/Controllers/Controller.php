<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @param $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public function sendResponse($message, $data = [], $status = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response,$status);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $status
     * @return JsonResponse
     */
    public function sendError($error = 'Error!', $errorMessages = [], $status = Response::HTTP_NOT_FOUND): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $status);
    }
}
