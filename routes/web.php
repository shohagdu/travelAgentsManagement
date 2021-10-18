<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationSetupController;
use App\Http\Controllers\AgentRecordController;
use App\Http\Controllers\AirlineSetupController;
use App\Http\Controllers\CountrySetupController;
use App\Http\Controllers\SaleCategoryController;
use App\Http\Controllers\SaleController;
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
Route::get('/organization-setup', [OrganizationSetupController::class, "index"])->name('organization-setup');
Route::post('/organization-setup-save', [OrganizationSetupController::class, "organization_save"])->name('organization-setup-save');

// Agent record setup 
Route::get('/agent-list', [AgentRecordController::class, "index"])->name('agent-list');
Route::get('/add-agent', [AgentRecordController::class, "create"])->name('add-agent');
Route::post('/save-agent', [AgentRecordController::class, "store"])->name('save-agent');
Route::get('/agent-edit/{id}', [AgentRecordController::class, "edit"])->name('agent-edit');
Route::post('/agent-update/{id}', [AgentRecordController::class, "update"])->name('agent-update');
Route::get('/agent-delete/{id}', [AgentRecordController::class, "destroy"])->name('agent-delete');
Route::post('/get_agent_list_data', [AgentRecordController::class, "get_agent_list_data"])->name('get_agent_list_data');

Route::post('/get_city_info', [AgentRecordController::class, 'get_city_info'])->name('get_city_info');

// Airline setup 
Route::get('/airline-setup', [AirlineSetupController::class, "create"])->name('airline-setup');
Route::post('/airline-setup-save', [AirlineSetupController::class, "store"])->name('airline-setup-save');
Route::get('/airline-setup-list', [AirlineSetupController::class, "index"])->name('airline-setup-list');
Route::get('/airline-setup-edit/{id}', [AirlineSetupController::class, "edit"])->name('airline-setup-edit');
Route::post('/airline-setup-update/{id}', [AirlineSetupController::class, "update"])->name('airline-setup-update');
Route::get('/airline-setup-delete/{id}', [AirlineSetupController::class, "destroy"])->name('airline-setup-delete');
Route::post('/airline_info_all', [AirlineSetupController::class, "airline_info_all"])->name('airline_info_all');

// Country setup 
Route::get('/country-setup-list', [CountrySetupController::class, "index"])->name('country-setup-list');
Route::get('/country-setup', [CountrySetupController::class, "create"])->name('country-setup');
Route::post('/country-setup-save', [CountrySetupController::class, "store"])->name('country-setup-save');
Route::get('/country-setup-edit/{id}', [CountrySetupController::class, "edit"])->name('country-setup-edit');
Route::post('/country-setup-update/{id}', [CountrySetupController::class, "update"])->name('country-setup-update');
Route::get('/country-setup-delete/{id}', [CountrySetupController::class, "destroy"])->name('country-setup-delete');

// Sale category 
Route::get('/sale-category-list', [SaleCategoryController::class, "index"])->name('sale-category-list');
Route::get('/sale-category', [SaleCategoryController::class, "create"])->name('sale-category');
Route::post('/sale-category-save', [SaleCategoryController::class, "store"])->name('sale-category-save');
Route::get('/sale-category-edit/{id}', [SaleCategoryController::class, "edit"])->name('sale-category-edit');
Route::post('/sale-category-update/{id}', [SaleCategoryController::class, "update"])->name('sale-category-update');
Route::get('/sale-category-delete/{id}', [SaleCategoryController::class, "destroy"])->name('sale-category-delete');

// Sale 
Route::get('/sale', [SaleController::class, "create"])->name('sale');