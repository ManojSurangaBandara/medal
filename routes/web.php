<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegimentController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddmedalController;
use App\Http\Controllers\MultipleController;
use App\Http\Controllers\RtypeController;
use App\Http\Controllers\MedalProfileController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('regiments', RegimentController::class);
    Route::resource('ranks', RankController::class);
    Route::resource('units', UnitController::class);
    Route::resource('users', UserController::class);
    Route::resource('medals', MedalController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('persons', PersonController::class);
    Route::resource('addmedals', AddmedalController::class);
    Route::resource('multiples', MultipleController::class);
    Route::resource('rtypes', RtypeController::class);
    Route::resource('medal_profiles', MedalProfileController::class);

    Route::get('/medal_profiles/activate/{id}',[MedalProfileController::class,'activate_medal_profile'])->name('medal_profiles.activate');
    Route::get('/medal_profiles/close/{id}',[MedalProfileController::class,'close_medal_profile'])->name('medal_profiles.close');

    });

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
