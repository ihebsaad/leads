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

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ActivityController;


Route::resource('users', UsersController::class);
//Route::resource('clients', ClientsController::class);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Settings
Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::post('/update_setting', [App\Http\Controllers\SettingsController::class, 'update_setting'])->name('update_setting');


// users
Route::get('profile', [UsersController::class, 'profile'])->name('profile');
Route::post('/updateuser',[UsersController::class, 'updateuser'])->name('updateuser');
Route::get('/loginAs/{id}', [UsersController::class, 'loginAs'])->name('loginAs');
Route::post('/users/ajoutimage',[UsersController::class, 'ajoutimage'])->name('users.ajoutimage');
Route::post('/activer/{id}', [UsersController::class, 'activer'])->name('activer');
Route::post('/desactiver/{id}', [UsersController::class, 'desactiver'])->name('desactiver');

//clients
Route::group(['middleware' => ['auth']], function () {
    Route::resource('clients', ClientsController::class);
});

Route::post('clients/{id}/restore', [ClientsController::class, 'restore'])->name('clients.restore');
Route::post('/clients/export', [ClientsController::class, 'export'])->name('clients.export');
Route::post('/clients/import', [ClientsController::class, 'import'])->name('clients.import');
Route::get('/api/leads', [ClientsController::class, 'store_api']);
Route::post('/api/leads', [ClientsController::class, 'store_api']);



//activities
Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
Route::post('/activities/{id}/restore', 'ActivityController@restore')->name('activities.restore');

Route::post('/settheme', 'App\Http\Controllers\HomeController@settheme')->name('settheme');

