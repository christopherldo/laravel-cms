<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site;
use App\Http\Controllers\Admin;

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

Route::get('/', [Site\HomeController::class, 'index']);

Route::prefix('painel')->group(function(){
    Route::get('/', [Admin\HomeController::class, 'index'])->name('admin');
    Route::post('/', [Admin\HomeController::class, 'index']);

    Route::get('login', [Admin\Auth\LoginController::class, 'index'])->name('login');
    Route::post('login', [Admin\Auth\LoginController::class, 'authenticate']);

    Route::get('register', [Admin\Auth\RegisterController::class, 'index'])->name('register');
    Route::post('register', [Admin\Auth\RegisterController::class, 'register']);

    Route::get('logout', [Admin\Auth\LoginController::class, 'logout'])->name('logout');
    Route::post('logout', [Admin\Auth\LoginController::class, 'logout']);

    Route::resource('users', Admin\UserController::class);
    Route::resource('pages', Admin\PageController::class);

    Route::get('profile', [Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('profile/save', [Admin\ProfileController::class, 'save'])->name('profile.save');

    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings');
    Route::put('settings/save', [Admin\SettingController::class, 'save'])->name('settings.save');
});

Route::fallback([Site\PageController::class, 'index']);
