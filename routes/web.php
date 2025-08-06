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
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MedalTypeController;
use App\Http\Controllers\ExcelController;
use App\Models\MedalProfile;
use App\Http\Controllers\ClaspProfileController;
use App\Http\Controllers\AddclaspController;
use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\MedalDataOldController;
use App\Http\Controllers\UploadMedalDataController;

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
    Route::resource('medal_types', MedalTypeController::class);
    Route::resource('application_forms', ApplicationFormController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('persons', PersonController::class);
    Route::resource('addmedals', AddmedalController::class);
    Route::resource('multiples', MultipleController::class);
    Route::resource('rtypes', RtypeController::class);
    Route::resource('medal_profiles', MedalProfileController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('clasp_profiles', ClaspProfileController::class);
    Route::resource('addclasps', AddclaspController::class);

    Route::get('/medal_profiles/activate/{id}', [MedalProfileController::class, 'activate_medal_profile'])->name('medal_profiles.activate');
    Route::get('/medal_profiles/close/{id}', [MedalProfileController::class, 'close_medal_profile'])->name('medal_profiles.close');

    Route::get('clasp_profiles/{id}/activate', [ClaspProfileController::class, 'activate_clasp_profile'])->name('clasp_profiles.activate');
    Route::get('clasp_profiles/{id}/close', [ClaspProfileController::class, 'close_clasp_profile'])->name('clasp_profiles.close');

    Route::get('persons/search/ajax', [PersonController::class, 'person_search_ajax'])->name('persons.search.ajax');
    Route::get('reports/person_profile', [ReportController::class, 'person_profile'])->name('reports.person_profile');
    Route::post('reports/person_profile_show', [ReportController::class, 'person_profile_show'])->name('reports.person_profile_show');

    Route::get('addmedal/create_bulk', [AddmedalController::class, 'create_bulk'])->name('addmedal.create_bulk');
    Route::post('addmedal/store_bulk', [AddmedalController::class, 'store_bulk'])->name('addmedal.store_bulk');

    Route::get('addclasp/create_bulk', [AddclaspController::class, 'create_bulk'])->name('addclasp.create_bulk');
    Route::post('addclasp/store_bulk', [AddclaspController::class, 'store_bulk'])->name('addclasp.store_bulk');
    Route::post('addclasp/store_ajax', [AddclaspController::class, 'store_ajax'])->name('addclasp.store_ajax');

    Route::get('medal_data_old/upload', [MedalDataOldController::class, 'showUploadForm'])->name('medal_data_old.upload_form');
    Route::post('medal_data_old/upload', [MedalDataOldController::class, 'upload'])->name('medal_data_old.upload');
    Route::get('medal_data_old', [MedalDataOldController::class, 'index'])->name('medal_data_old.index');

});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
