<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success responses
     *
     * @param string|array $data
     * @param int $code
     * @return Response
     */
    public function successResponse($data, $code = Response::HTTP_OK): Response
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * Build error responses
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Build error responses
     *
     * @param string $message
     * @param int $code
     * @return Response
     */
    public function errorMessage($message, $code): Response
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }

    public function convertForGetRequest($request): string
    {
        $data = '';
        foreach ($request->except('_token') as $key => $part) {
            if(isset($key) && isset($part)){
                $data .= "$key=$part&";
            }
        }
        return $data;
    }
}
