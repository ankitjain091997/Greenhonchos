<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;

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
    return view('auth.login');
})->name('login');

Route::get('/crate/account', function () {
    return view('auth.registration');
})->name('register');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('/submit/login', [AuthController::class, 'login'])->name('submit');
Route::post('registration', [AuthController::class, 'registration']);

Route::middleware('auth')->prefix('blogs')->group(function () {

    Route::get('/', function () {
        return view('blogs.list');
    })->name('blogs');

    Route::get('list', [BlogsController::class, 'blogs']);
    Route::post('store', [BlogsController::class, 'store']);
    Route::get('edit/{id}', [BlogsController::class, 'edit']);
    Route::get('show/{id}', [BlogsController::class, 'show']);
    Route::delete('delete/{id}', [BlogsController::class, 'destroy']);
});
