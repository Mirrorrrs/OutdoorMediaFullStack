<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\ViewController::class, "home"])->name("home");

Route::get("/billboard/{id}",[\App\Http\Controllers\ViewController::class, "billboard"] )->name("billboard");

Route::get('login', [\App\Http\Controllers\ViewController::class, "login"])->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class, "login"])->name("loginPOST");

Route::middleware("CheckAuth")->group(function(){
    Route::get("admin",[\App\Http\Controllers\ViewController::class, "adminBillboards"])->name("adminPanelBillboards");
    Route::post("admin/loadExcel", [\App\Http\Controllers\BillboardController::class,"storeDataFromExcel"])->name("storeDataFromExcel");
    Route::post("billboard/update/{id}", [\App\Http\Controllers\BillboardController::class,"updateInfo"])->name("updateBillboardInfo");
    Route::get("logout", [\App\Http\Controllers\AuthController::class,"logout"])->name("logout");
    Route::post("billboard/update/image/{id}", [\App\Http\Controllers\BillboardController::class, "updateImage"])->name("updateBillboardImage");
});


