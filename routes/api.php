<?php

use Illuminate\Http\Request;
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

Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post("user/status/{id}", [App\Http\Controllers\Api\AuthController::class, 'updatestatus'])->middleware('auth:sanctum');


Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\Api\CatoriesController::class, 'index']);
    Route::post('/create', [App\Http\Controllers\Api\CatoriesController::class, 'create']);
    Route::get('/edit/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'edit']);
    Route::patch('/update/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'delete']);
});

Route::get('category', [App\Http\Controllers\Api\GeneralApi::class, 'category']);


Route::group(['prefix' => '/wasfas', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/index', [App\Http\Controllers\Api\WasfasController::class, 'index']);
    Route::post("/create", [App\Http\Controllers\Api\WasfasController::class, 'create']);
    Route::get("/show/{id}", [App\Http\Controllers\Api\WasfasController::class, 'show']);
    Route::patch("/update/{id}", [App\Http\Controllers\Api\WasfasController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\WasfasController::class, 'delete']);
});

Route::group(['prefix' => '/wasfacontent', 'middleware' => 'auth:sanctum'], function () {
    Route::post("/create", [App\Http\Controllers\Api\WasfasContenetController::class, 'create']);
    Route::get("/show/{id}", [App\Http\Controllers\Api\WasfasContenetController::class, 'show']);
    Route::patch("/update/{id}", [App\Http\Controllers\Api\WasfasContenetController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\WasfasContenetController::class, 'delete']);
});
//حجوزات
Route::group(['prefix' => 'reservation', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\Api\ReservationController::class, 'index']);
    Route::get('/userReservation', [App\Http\Controllers\Api\ReservationUserController::class, 'index']);
    Route::post('/store', [App\Http\Controllers\Api\ReservationUserController::class, 'store']);
    Route::get('/edit/{id}', [App\Http\Controllers\Api\ReservationUserController::class, 'edit']);
    Route::patch('/update/{id}', [App\Http\Controllers\Api\ReservationUserController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\ReservationUserController::class, 'delete']);



    Route::patch('/updatestatus/{id}', [App\Http\Controllers\Api\ReservationController::class, 'updatestatus']);
    Route::post('/payment/{id}', [App\Http\Controllers\Api\ReservationUserController::class, 'payment']);

    Route::group(['prefix' => '/rating'], function () {
        Route::get('/', [App\Http\Controllers\Api\RatingReservationController::class, 'index']);
        Route::post('/store/{id}', [App\Http\Controllers\Api\RatingReservationController::class, 'store']);
    });
});


Route::group(['prefix' => 'contactus', 'middleware' => 'auth:sanctum'], function () {
    Route::get("/", [App\Http\Controllers\Api\ContactusController::class, 'index']);
});
Route::post("/contactus", [App\Http\Controllers\Api\ContactusController::class, 'create']);

Route::get('/chefs', [App\Http\Controllers\Api\UsersController::class, 'chefs']);

//مستخدمين
Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\Api\UsersController::class, 'users']);
});

Route::group(['prefix' => 'setting', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [App\Http\Controllers\Api\SettingsController::class, 'index']);
    Route::patch('update', [App\Http\Controllers\Api\SettingsController::class, 'update']);
});
//خدمات الموقع
Route::group(['prefix' => 'services', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\Api\ServicesController::class, 'index']);
    Route::post('/store', [App\Http\Controllers\Api\ServicesController::class, 'store']);
    Route::get('/edit/{id}', [App\Http\Controllers\Api\ServicesController::class, 'edit']);
    Route::patch('/update/{id}', [App\Http\Controllers\Api\ServicesController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\ServicesController::class, 'delete']);

    Route::get('/service-user', [App\Http\Controllers\Api\ServicesController::class, 'serviceusers']);

    Route::post('/service-user/{id}', [App\Http\Controllers\Api\ServicesController::class, 'user_register']);
});
Route::get('getservices', [App\Http\Controllers\Api\ServicesController::class, 'services'])->middleware('auth:sanctum');


Route::get('wasfas', [App\Http\Controllers\Api\WasfasUserController::class, 'index']);


Route::get('wasfa/show/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'show']);

Route::post('wasfa/create', [App\Http\Controllers\Api\WasfasUserController::class, 'create'])->middleware('auth:sanctum');
Route::get('wasfa/subscribe', [App\Http\Controllers\Api\WasfasUserController::class, 'subscribe'])->middleware('auth:sanctum');
Route::post('wasfa/subscribe/edit/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'subscribeedit'])->middleware('auth:sanctum');
Route::patch('wasfa/subscribe/update/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'subscribeupdate'])->middleware('auth:sanctum');
Route::delete('wasfa/subscribe/delete/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'subscribedelete'])->middleware('auth:sanctum');

Route::group(['prefix' => '/wasfa/chef', 'middleware' => 'auth:sanctum'], function () {
    Route::patch('/update/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'updateStatus']);
    Route::post('/payment/{id}', [App\Http\Controllers\Api\WasfasUserController::class, 'payment']);

    Route::group(['prefix' => '/rating'], function () {
        Route::get('/', [App\Http\Controllers\Api\RatingWasfaController::class, 'index']);
        Route::post('/store/{id}', [App\Http\Controllers\Api\RatingWasfaController::class, 'store']);
    });
});


/**this test class */

/* Route::get('') */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::middleware('auth:api')->get('/users', function (Request $request) {
    return $request->user();
});
*/