<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
// Route::get('/', function () {
//     return view('master.user');
// });


// prefix bisa dianggap pengelompokkan
Route::prefix('/user')
    ->middleware(['auth'])
    ->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    });

Route::prefix('/register')
    ->middleware(['guest'])
    ->group(function () {
    Route::get('/', [UserController::class, 'register'])->name('user.register');
    Route::post('/register_user', [UserController::class, 'register_user'])->name('user.register_user');
    });

Route::middleware(['guest'])
    ->group(function () {
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::get('/login_user', [UserController::class, 'login_user'])->name('login_user');
    });

Route::post('/logout', [UserController::class, 'logout'])->name('logout');