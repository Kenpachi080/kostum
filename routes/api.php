<?php

use App\Http\Controllers\admin\DatabaseController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\AuthController as AuthController;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('/code', [AuthController::class, 'code'])->name('code');
    Route::post('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
});

Route::group(['prefix' => 'auth', 'middleware' => "api_auth"], function () {
    Route::post('/rebootpassword', [AuthController::class, 'rebootpassword'])->name('rebootpassword');
    Route::post('/change', [AuthController::class, 'change'])->name('change');
    Route::post('/view', [AuthController::class, 'view'])->name('authview');
});

Route::group(['prefix' => 'table'], function () {
    Route::get('/', [DatabaseController::class, 'index']); // показать все таблицы
    Route::get('/{table}', [DatabaseController::class, 'show']); // показать таблицу
    Route::get('/{table}/{id}', [DatabaseController::class, 'showOnly']); // показать отдельную запись в таблице
    Route::post('/rules/{table}', [DatabaseController::class, 'rules']); // создать правила для таблицы
    Route::post('/{table}', [DatabaseController::class, 'create']); // создать запись в таблице
    Route::put('/{table}/{id}', [DatabaseController::class, 'update']); // обновить запись в таблице
    Route::delete('/{table}/{id}', [DatabaseController::class, 'delete']); // удалить записть в таблице
});

// route create:  POST /admin/{table->slug}
