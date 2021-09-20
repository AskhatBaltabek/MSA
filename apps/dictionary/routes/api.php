<?php

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\InsuranceObjectsController;
use App\Http\Controllers\InsuranceRisksController;
use App\Http\Controllers\InsuranceTypesController;
use App\Http\Controllers\ObjectTypesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
});
Route::middleware('auth:jwt')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('test', [BaseController::class, 'test']);
Route::get('test2', [BaseController::class, 'test2']);

/* Cars routes */
Route::get('cars/sync-marks', [CarsController::class, 'syncMarksFromKolesa']);
Route::get('cars/sync-models', [CarsController::class, 'syncModelsFromKolesa']);
/* End cars routes */


/* Settings routes */
Route::match(['patch', 'put'], 'settings/{key}', [SettingsController::class, 'updateByKey']);
//Route::get('settings/{key}', [SettingsController::class, 'showByKey']);
//Route::get('settings/{key}/value', [SettingsController::class, 'getValueByKey']);
/* End settings routes */

Route::get('products/sync-ones', [ProductsController::class, 'syncOneS']);
Route::get('insurance-risks/sync-ones', [InsuranceRisksController::class, 'syncOneS']);
Route::get('insurance-objects/sync-ones', [InsuranceObjectsController::class, 'syncOneS']);
Route::get('insurance-types/sync-ones', [InsuranceTypesController::class, 'syncOneS']);

/* ДОЛЖНЫ БЫТЬ В КОНЦЕ */
/* Multipurpose routes */
Route::get('{modelName}/default-n-fields', [BaseController::class, 'getDefaultNFields']);
Route::get('{modelName}/{id?}', [BaseController::class, 'show']);
Route::get('{modelName}/{fieldName}/{fieldValue}', [BaseController::class, 'showByField']);
Route::post('{modelName}', [BaseController::class, 'create']);
Route::match(['patch', 'put', 'post'],'{modelName}/{id}', [BaseController::class, 'update']);
Route::delete('{modelName}/{id}', [BaseController::class, 'delete']);
/* End multipurpose routes */

