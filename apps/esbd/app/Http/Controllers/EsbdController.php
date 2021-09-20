<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallMethodRequest;
use App\Services\TheEsbdService;
use Illuminate\Http\JsonResponse;

class EsbdController extends BaseController
{
    /**
     * @param CallMethodRequest $request
     * @return JsonResponse
     */
    public function callMethod(CallMethodRequest $request): JsonResponse
    {
        $data = TheEsbdService::callMethod($request->methodName, $request->params);

        return $this->sendResponseSuccess('Запрос успешно выполнен!', $data);
    }
}
