<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\MitiController;

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


// Redirect ke dashboard setelah login
Route::get('/', fn() => redirect('/dashboard'))->middleware('auth');

// Rute untuk halaman yang hanya bisa diakses setelah login (dengan middleware 'auth')
Route::middleware('auth')->group(function () {
    Route::view('/profile', 'account-pages.profile')->name('profile');

    Route::resource('risk', RiskController::class);
    Route::get('/dashboard', [RiskController::class, 'index'])->name('dashboard');
    Route::get('admin.create', [RiskController::class, 'create'])->name('admin.create');
    
    Route::resource('miti', MitiController::class);
    Route::get('miti/create', [MitiController::class, 'create'])->name('miti.create');
    Route::get('/miti/{id}/edit', [MitiController::class, 'edit'])->name('miti.edit');
    Route::delete('miti/{id}', [MitiController::class, 'destroy'])->name('miti.destroy');
    Route::put('miti/{id}', [MitiController::class, 'update'])->name('miti.update');
    

    

    Route::resource('value', ValueController::class);
    Route::get('admin.value', [ValueController::class, 'create'])->name('admin.value');
    
    
    Route::delete('risk/{id}', [RiskController::class, 'destroy'])->name('risk.destroy');
    Route::get('risk/{id}/edit', [RiskController::class, 'edit'])->name('admin.edit');
    Route::put('risk/{id}', [RiskController::class, 'update'])->name('risk.update');
    
    
    // Rute untuk logout
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    
    // Add these routes within your auth middleware group
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // Laravel examples
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('update');
    Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management');
    Route::get('/user-management', [ProfileController::class, 'userManagement'])->name('user.management');
    Route::post('/user-management/update/{id}', [ProfileController::class, 'updateUser'])->name('user.update');
    Route::post('/user-management/store', [ProfileController::class, 'storeUser'])->name('user.store');
});

// Rute untuk tamu (guest) yang belum login
Route::middleware('guest')->group(function () {
    Route::view('/signin', 'account-pages.signin')->name('signin');
    Route::view('/signup', 'account-pages.signup')->name('signup');
    
    // Rute untuk registrasi
    Route::get('/sign-up', [RegisterController::class, 'create'])->name('sign-up');
    Route::post('/sign-up', [RegisterController::class, 'store']);
    
    // Rute untuk login
    Route::get('/sign-in', [LoginController::class, 'create'])->name('sign-in');
    Route::post('/sign-in', [LoginController::class, 'store']);
    
    // Rute untuk lupa password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store']);
});



Route::group(['middleware' => 'auth'], function () {
    // Use the resource route for users
    Route::resource('users', UserController::class); 
	Route::resource('risks', RiskController::class);
	Route::resource('values', ValuesController::class);

    // Profile routes
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    
    // Dynamic page routes
    // Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
