<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RestService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RestController extends Controller
{
    use ApiResponser;

    public $restService;

    public function __construct(RestService $restService)
    {
        $this->restService = $restService;
    }

    public function getCar(Request $request)
    {
        $data = $this->convertForGetRequest($request);

        return $this->successResponse($this->restService->obtainCar($data));
    }
}
