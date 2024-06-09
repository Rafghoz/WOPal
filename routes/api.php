<?php

use App\Http\Controllers\CMS\AuthController;
use App\Http\Controllers\CMS\PackagesController;
use App\Http\Controllers\CMS\BookingController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\WoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/visitors/count', [DashboardController::class, 'getVisitorCount']);

Route::middleware(['auth', 'web'])->group(function () {

    Route::prefix('v1/Wopal')->group(function () {
        Route::get('/', [WoController::class, 'getAllData']);
        Route::get('/profile', [WoController::class, 'getDataByUser']);
        Route::post('/create', [WoController::class, 'createData']);
        Route::get('/get/{id}', [WoController::class, 'getDataById']);
        Route::post('/update/{id}', [WoController::class, 'updateData']);
        Route::delete('/delete/{id}', [WoController::class, 'deleteData']);
    });

Route::prefix('v1/packages')->controller(PackagesController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::get('/get/wo', 'getAllDataByWO');
    Route::post('/update/{id}', 'updateData');
    Route::get('/get/wo/{id_wedding}', 'getDataPacketByWO');
    Route::delete('/delete/{id}', 'deleteData');
});
Route::prefix('v1/bookings')->controller(BookingController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    // Route::post('/update/{id}', 'updateData');
    Route::delete('/delete/{id}', 'deleteData');
});


Route::prefix('v1/auth')->controller(AuthController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/createDataUser', 'createUser');
    Route::post('/createDataAdmin', 'createAdmin');
    Route::get('/getDataById/{id}', 'getDataById');
    Route::post('/updateData/{id}', 'updateData');
    Route::delete('/deleteData/{id}', 'deleteData');
    Route::post('/login', 'login');
});

});

