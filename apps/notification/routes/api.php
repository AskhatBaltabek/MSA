<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\EmailController;
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

Route::group(['middleware' => 'auth:jwt'], function ($router) {
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('notification-templates', NotificationTemplateController::class);
});

Route::group(['prefix' => 'sms'], function () {
    Route::get('list', [SmsController::class, 'list'])->middleware(['auth:jwt']);
    Route::post('send', [SmsController::class, 'save']);
//    Route::post('sending', [SmsController::class, 'sending']);

    Route::post('send-template', [SmsController::class, 'sendTemplate']);
});
Route::group(['prefix' => 'email'], function () {
    Route::get('list', [EmailController::class, 'list'])->middleware(['auth:jwt']);;
    Route::post('send', [EmailController::class, 'save']);
    Route::post('send-template', [EmailController::class, 'sendTemplate']);
});
