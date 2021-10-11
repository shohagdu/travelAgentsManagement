<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationSetupController;
use App\Http\Controllers\AgentRecordController;
use App\Http\Controllers\AirlineSetupController;

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
    return view('user.login');
});

Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');

// User area 
Route::get('/user-list', [UserController::class, "index"])->name('user-list');
Route::get('/add-user', [UserController::class, "create"])->name('add-user');
Route::post('/user-register', [UserController::class, "store"])->name('user-register');
Route::get('/user-edit/{id}', [UserController::class, "edit"])->name('user-edit');
Route::post('/user-update/{id}', [UserController::class, "update"])->name('user-update');
Route::get('/user-delete/{id}', [UserController::class, "destroy"])->name('user-delete');

// Organization setup 
Route::get('/organization-setup', [OrganizationSetupController::class, "create"])->name('organization-setup');


// Agent record setup 
Route::get('/add-agent', [AgentRecordController::class, "create"])->name('add-agent');

Route::post('/get_city_info', [AgentRecordController::class, 'get_city_info'])->name('get_city_info');

// Airline setup 
Route::get('/airline-setup', [AirlineSetupController::class, "create"])->name('airline-setup');