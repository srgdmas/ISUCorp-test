<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicasController;
use App\Http\Controllers\ContactsTypesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrazasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::post('/', [UserController::class, 'index']);
    Route::post('/promotors', [UserController::class, 'get_promotors']);
    Route::post('/new', [UserController::class, 'store']);
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::post('/delete/{id}', [UserController::class, 'delete']);
    Route::post('/new-admin', [UserController::class, 'newAdmin']);
    Route::post('/profile', [UserController::class, 'profile']);
    Route::post('/active-user', [UserController::class, 'active_user']);
    Route::post('/change-password', [UserController::class, 'change_password']);
    Route::post('/recover-password', [UserController::class, 'recover_password']);
    Route::post('/get-user', [UserController::class, 'get_user']);
    Route::post('/desactivate', [UserController::class, 'deactivate']);
    Route::post('/activate', [UserController::class, 'activate']);
    Route::post('/{id}', [UserController::class, 'show']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'roles'
], function ($router) {
    Route::post('/', [RoleController::class, 'index']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'notification'
], function ($router) {
    Route::post('/', [NotificationController::class, 'index']);
    Route::post('/app-notifications', [NotificationController::class, 'list_app_notifications']);
    Route::post('/read-one', [NotificationController::class, 'read_one']);
    Route::post('/read-all', [NotificationController::class, 'read_all']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'trazas'
], function ($router) {
    Route::post('/', [TrazasController::class, 'index']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'reservations'
], function ($router) {
    Route::post('/', [ReservationsController::class, 'index']);
    Route::post('/new', [ReservationsController::class, 'store']);
    Route::post('/{id}', [ReservationsController::class, 'show']);
    Route::post('/update/{id}', [ReservationsController::class, 'update']);
    Route::post('/delete/{id}', [ReservationsController::class, 'destroy']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'contacts-types'
], function ($router) {
    Route::post('/', [ContactsTypesController::class, 'index']);
    Route::post('/new', [ContactsTypesController::class, 'store']);
    Route::post('/{id}', [ContactsTypesController::class, 'show']);
    Route::post('/update/{id}', [ContactsTypesController::class, 'update']);
    Route::post('/delete/{id}', [ContactsTypesController::class, 'destroy']);
});
