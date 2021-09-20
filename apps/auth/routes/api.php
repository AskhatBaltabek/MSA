<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RestController;
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
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('/users/import-users', [UsersController::class, 'importUsers']);
    Route::get('/users/import-roles', [UsersController::class, 'importRolesWB']);
    Route::get('/users/set-users-roles', [UsersController::class, 'setUsersRoles']);
});

Route::middleware('jwt.verify')->group(function() {

    Route::get('get-car', [RestController::class, 'getCar']);

    /* Users routes */
    Route::get('user', [UsersController::class, 'getUser']);
    Route::get('users', [UsersController::class, 'getUsers']);
    Route::post('store_user', [UsersController::class, 'storeUser']);
    Route::post('delete_user', [UsersController::class, 'deleteUser']);
    /* End users routes */

    /* Multipurpose routes */
    Route::get('{modelName}/default-n-fields', [BaseController::class, 'getDefaultNFields']);
    Route::get('{modelName}/{id?}', [BaseController::class, 'index']);
    Route::get('{modelName}/{fieldName}/{fieldValue}', [BaseController::class, 'showByField']);
    Route::post('{modelName}', [BaseController::class, 'create']);
    Route::match(['patch', 'post'],'{modelName}/{id}', [BaseController::class, 'update']);
    Route::delete('{modelName}/{id}', [BaseController::class, 'delete']);
    /* End multipurpose routes */
});

Route::get('/users/sync/ones', [UsersController::class, 'syncOneS']);


