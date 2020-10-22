<?php

use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    // Before Login Admin Routes
    Route::group(['middleware' => 'admin.guest'], function() {
        Route::view('login', 'admin.login')->name('admin.login');
        Route::post('login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.auth');
    });

    // After Login Admin Routes
    Route::group(['middleware' => 'admin.auth'], function() {
        Route::get('dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.home');

        Route::view('add-exchange', 'admin.exchange.add')->name('admin.exchange.add');
        Route::post('exchange-save', [App\Http\Controllers\Exchange\ExchangeController::class, 'create'])->name('exchange.save');
        
        Route::get('edit-exchange', [App\Http\Controllers\Exchange\ExchangeController::class, 'edit'])->name('exchange.edit');
        Route::post('exchange-update', [App\Http\Controllers\Exchange\ExchangeController::class, 'update'])->name('exchange.update');

        Route::get('delete-exchange', [App\Http\Controllers\Exchange\ExchangeController::class, 'delete'])->name('exchange.delete');
        Route::post('report', [App\Http\Controllers\Exchange\ExchangeController::class, 'report'])->name('exchange.report');

        Route::post('logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    });
});