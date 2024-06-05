<?php

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
Route::get('/Profile', function () {
    return view('cms.Profile');
});
Route::get('/Wedding-Organizer', function () {
    return view('cms.WO');
});
Route::get('/cms/usermanagement', function () {
    return view('cms.Usermanagement');
});

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
    return view('web/Login');
});
Route::get('/registrasi', function () {
    return view('web/Registrasi');
});
Route::get('/detail-produk', function () {
    return view('web/detailproduk');
});
Route::get('/detail-WO', function () {
    return view('web/detailWo');
});
