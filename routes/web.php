<?php

use App\Http\Controllers\CMS\AuthController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\PackagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMS\WoController;

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



Route::get('/visitors/count', [DashboardController::class, 'showVisitorsCount'])->name('visitors.count');

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
    if (is_numeric($parameter)) {
        return view('web.detailWo', ['parameter' => $parameter]);
    } else {
        return view('web.notFound');
    }
});

Route::get('/detail-produk/{parameter}', function ($parameter) {
    if (is_numeric($parameter)) {
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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'web'])->group(function () {
    Route::prefix('v1/packages')->controller(PackagesController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::get('/get/wo', 'getAllDataByWO');
        Route::post('/create', 'createData');
    });


    Route::get('/admin-dashboard', function () {
        return view('cms.Dashboard');
    })->name('admin.dashboard');

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

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/superadmin-dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');

    Route::get('/booking', function () {
        return view('booking');})->name('booking');
        
});
