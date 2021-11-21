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
use App\Http\Controllers\BankController;
use App\Http\Controllers\BillCollectionController;
use App\Http\Controllers\ReportController;

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
Route::get('/today-sale-balance-view', [DashboardController::class, "today_sale_balance_view"])->name('today-sale-balance-view');
Route::get('/today-credit-balance-view', [DashboardController::class, "today_credit_balance_view"])->name('today-credit-balance-view');

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

Route::get('/agent-statement/{id}', [AgentRecordController::class, "agent_statement"])->name('agent-statement');

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

// Bank setup 
Route::get('/bank-list', [BankController::class, "index"])->name('bank-list');
Route::get('/bank-create', [BankController::class, "create"])->name('bank-create');
Route::post('/bank-save', [BankController::class, "store"])->name('bank-save');
Route::get('/bank-edit/{id}', [BankController::class, "edit"])->name('bank-edit');
Route::post('/bank-update/{id}', [BankController::class, "update"])->name('bank-update');
Route::get('/bank-delete/{id}', [BankController::class, "destroy"])->name('bank-delete');

// Sale category 
Route::get('/sale-category-list', [SaleCategoryController::class, "index"])->name('sale-category-list');
Route::get('/sale-category', [SaleCategoryController::class, "create"])->name('sale-category');
Route::post('/sale-category-save', [SaleCategoryController::class, "store"])->name('sale-category-save');
Route::get('/sale-category-edit/{id}', [SaleCategoryController::class, "edit"])->name('sale-category-edit');
Route::post('/sale-category-update/{id}', [SaleCategoryController::class, "update"])->name('sale-category-update');
Route::get('/sale-category-delete/{id}', [SaleCategoryController::class, "destroy"])->name('sale-category-delete');

// Sale 
Route::get('/sale-list', [SaleController::class, "index"])->name('sale-list');
Route::post('/get_sale_list_data', [SaleController::class, "get_sale_list_data"])->name('get_sale_list_data');
Route::get('/today-sale-list', [SaleController::class, "today_sale_list"])->name('today-sale-list');
Route::post('/get_today_sale_list_data', [SaleController::class, "get_today_sale_list_data"])->name('get_today_sale_list_data');
Route::get('/sale', [SaleController::class, "create"])->name('sale');
Route::get('/sale-edit/{id}', [SaleController::class, "edit"])->name('sale-edit');
Route::post('/sale-update', [SaleController::class, "update"])->name('sale-update');
Route::post('/sale-delete', [SaleController::class, "destroy"])->name('sale-delete');
Route::get('/sale-invoice/{id}', [SaleController::class, "sale_invoice"])->name('sale-invoice');
Route::post('/sale-save', [SaleController::class, "store"])->name('sale-save');
Route::post('/get_flight_setup_info', [SaleController::class, "get_flight_setup_info"])->name('get_flight_setup_info');

// Bill Colleaction 
Route::get('/bill-collection', [BillCollectionController::class, "index"])->name('bill-collection');
Route::post('/bill-collection-save', [BillCollectionController::class, "store"])->name('bill-collection-save');
Route::post('/bill_collection_row_data', [BillCollectionController::class, "edit"])->name('bill_collection_row_data');
Route::post('/bill_collection_delete', [BillCollectionController::class, "bill_collection_delete"])->name('bill_collection_delete');
Route::post('/get_bill_collection_list_data', [BillCollectionController::class, "get_bill_collection_list_data"])->name('get_bill_collection_list_data');

Route::post('/agent_bill_payment_data', [BillCollectionController::class, "agent_bill_payment_data"])->name('agent_bill_payment_data');

// Bill Refund 
Route::get('/bill-refund', [BillCollectionController::class, "bill_refund"])->name('bill-refund');
Route::post('/bill-refund-save', [BillCollectionController::class, "bill_refund_save"])->name('bill-refund-save');
Route::post('/bill_refund_row_data', [BillCollectionController::class, "bill_refund_row_data"])->name('bill_refund_row_data');
Route::post('/bill_refund_delete', [BillCollectionController::class, "bill_refund_delete"])->name('bill_refund_delete');
Route::post('/get_bill_refund_list_data', [BillCollectionController::class, "get_bill_refund_list_data"])->name('get_bill_refund_list_data');

// Statement report
Route::get('/statement-report', [ReportController::class, "index"])->name('statement-report');
Route::post('/get_statement_report_data', [ReportController::class, "get_statement_report_data"])->name('get_statement_report_data');

// Account Wise report
Route::get('/account-report', [BankController::class, "account_report"])->name('account-report');
Route::post('/get_account_report_data', [BankController::class, "get_account_report_data"])->name('get_account_report_data');
