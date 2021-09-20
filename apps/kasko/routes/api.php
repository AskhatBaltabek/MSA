<?php

use App\Http\Controllers\BaseController;
use App\Http\Controllers\InsuranceObjectsController;
use App\Http\Controllers\InsuranceRisksController;
use App\Http\Controllers\InsuranceTypesController;
use App\Http\Controllers\KaskoController;
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

Route::middleware('auth:jwt')->group(function ($router) {
    Route::post('set-policy', [KaskoController::class, 'setPolicy']);
    Route::post('rescinding-policy', [KaskoController::class, 'rescindingPolicy']);
    Route::post('cancel-policy', [KaskoController::class, 'cancelPolicy']);
    Route::get('get-car-average-price', [KaskoController::class, 'getCarAveragePrice']);
    Route::get('get-marks', [KaskoController::class, 'getMarks']);
    Route::get('get-car', [KaskoController::class, 'getCarFromEsbd']);
    Route::get('set-car', [KaskoController::class, 'setCar']);
    Route::get('get-template', [KaskoController::class, 'getTemplate']);
    Route::get('get-tarifes', [KaskoController::class, 'getTarifes']);


    /* ДОЛЖНЫ БЫТЬ В КОНЦЕ */
    /* Multipurpose routes */
    Route::get('{modelName}/default-n-fields', [BaseController::class, 'getDefaultNFields']);
    Route::get('{modelName}/{id?}', [BaseController::class, 'show']);
    Route::get('{modelName}/{fieldName}/{fieldValue}', [BaseController::class, 'showByField']);
    Route::post('{modelName}', [BaseController::class, 'create']);
    Route::match(['patch', 'put', 'post'],'{modelName}/{id}', [BaseController::class, 'update']);
    Route::delete('{modelName}/{id}', [BaseController::class, 'delete']);
    /* End multipurpose routes */

});


