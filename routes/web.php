<?php

use App\Http\Controllers\CMS\AuthController;
use App\Http\Controllers\CMS\BookingController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\PackagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMS\WoController;
use App\Models\PackagesModel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('web/index');
});
Route::get('/WO', function () {
    return view('web/Wo');
});
Route::get('/AboutUs', function () {
    return view('web/AboutUs');
});
Route::get('/Bergabung', function () {
    return view('web/Bergabung');
});
Route::get('/login', function () {
    return view('cms/auth/Login');
});
Route::get('/registrasi', function () {
    return view('cms/auth/Registrasi');})->name('register');

Route::get('/detail-WO', function () {
    return view('web/detailWo');
});

Route::get('/detail-WO/{parameter}', function ($parameter) {
    // if (is_numeric($parameter)) {
    if (is_numeric($parameter) && PackagesModel::find($parameter)) {
        return view('web.detailWo', ['parameter' => $parameter]);
    } else {
        return view('web.notFound');
    }
});

Route::get('/detail-produk/{parameter}', function ($parameter) {
    if (is_numeric($parameter) && PackagesModel::find($parameter)) {
        return view('web.detailproduk', ['parameter' => $parameter]);
    } else {
        return view('web.notFound');
    }
});

Route::middleware('guest')->group(function () {
    Route::get('/cms/login', function () {
        return view('cms/auth/Login');
    });
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/v1/packages/get', [PackagesController::class, 'getAllData']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'web'])->group(function () {


    Route::prefix('v1/auth')->controller(AuthController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/createDataUser', 'createUser');
        Route::post('/createDataAdmin', 'createAdmin');
        Route::get('/getDataById/{id}', 'getDataById');
        Route::post('/updateData/{id}', 'updateData');
        Route::delete('/deleteData/{id}', 'deleteData');
        Route::post('/login', 'login');
    });

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
        Route::get('/paket', 'getDataPacket');
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

    Route::get('/Dashboard', function () {
        return view('cms.Dashboard');
    });
    Route::get('/Bookings', function () {
        return view('cms.Bookings');
    });
    Route::get('/Packages', function () {
        return view('cms.Packages');
    });
    Route::get('/Daftar-WO', function () {
        return view('cms.DaftarWO');
    });
    Route::get('/Create-WO', function () {
        return view('cms.CreateWo');
    });
    Route::get('/Edit-WO', function () {
        return view('cms.EditWo');
    });
    Route::get('/cms/usermanagement', function () {
        return view('cms.Usermanagement');
    });
    Route::get('/cms/edit-user-dashboard', function () {
        return view('cms.ProfileUser');
    });
    Route::get('/cms/edit-user', function () {
        return view('cms.auth.EditUser');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/v1/admin-dashboard', [DashboardController::class, 'dashboardDataAdmin']);
    Route::get('/admin-dashboard', function () {
        return view('cms.Dashboard');
    })->name('admin.dashboard');

    Route::get('/v1/superadmin-dashboard', [DashboardController::class, 'dashboardDataSuperAdmin']);
    Route::get('/superadmin-dashboard', function () {
        return view('cms.DashboardSuperAdmin');
    })->name('superadmin.dashboard');

});
