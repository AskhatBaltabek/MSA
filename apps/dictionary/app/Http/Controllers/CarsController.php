<?php

namespace App\Http\Controllers;

use App\Models\CarMark;
use App\Models\CarModel;
use App\Services\KolesaService;
use Illuminate\Http\JsonResponse;

class CarsController extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function syncMarksFromKolesa(): JsonResponse
    {
        $data = KolesaService::GetMarkParser();

        try {
            CarMark::truncate();
            CarMark::insert($data);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse('Cars marks updated successfully!', []);
    }

    /**
     * @return JsonResponse
     */
    public function syncModelsFromKolesa(): JsonResponse
    {
        $marks = CarMark::all();
        $res = [];
        foreach ($marks as $mark) {
            $model = KolesaService::GetModelParser($mark->id);
            $res[] = $model;
        }

        try {
            CarModel::truncate();
            foreach($res as $models) {
                CarModel::insert($models);
            }
        } catch (\Exception $exception) {
            $this->sendError($exception->getMessage());
        }

        return $this->sendResponse('Cars models updated successfully!', []);
    }
}
