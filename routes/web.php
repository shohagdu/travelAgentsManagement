<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AclMenuRoleController;
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
Route::post('/searchTodaySaleBalanceBtnAction', [DashboardController::class, "searchTodaySaleBalanceBtnAction"])->name('searchTodaySaleBalanceBtnAction');
Route::get('/search_today_sale_balance_pdf/{id}', [DashboardController::class, "search_today_sale_balance_pdf"])->name('search_today_sale_balance_pdf');
Route::get('/today-credit-balance-view', [DashboardController::class, "today_credit_balance_view"])->name('today-credit-balance-view');
Route::get('/today-debit-balance-view', [DashboardController::class, "today_debit_balance_view"])->name('today-debit-balance-view');

Route::get('/due_list_view', [DashboardController::class, "due_list_view"])->name('due_list_view');
Route::post('/agent-due-balance-view', [DashboardController::class, "agent_due_balance_view"])->name('agent-due-balance-view');
Route::get('/advance_list_view', [DashboardController::class, "advance_list_view"])->name('advance_list_view');
Route::post('/agent-advance-balance-view', [DashboardController::class, "agent_advance_balance_view"])->name('agent-advance-balance-view');
Route::get('/due_statement', [DashboardController::class, "due_statement"])->name('due_statement');
Route::get('/dailyStatement', [ReportController::class, "dailyStatement"])->name('dailyStatement');
Route::get('/dailyStatementPdf/{from_date}/{to_date}', [ReportController::class, "dailyStatementPdf"])->name('dailyStatementPdf');



// User area
Route::get('/user-list', [UserController::class, "index"])->name('user-list');
Route::get('/add-user', [UserController::class, "create"])->name('add-user');
Route::post('/user-register', [UserController::class, "store"])->name('user-register');
Route::get('/user-edit/{id}', [UserController::class, "edit"])->name('user-edit');
Route::post('/user-update/{id}', [UserController::class, "update"])->name('user-update');
Route::get('/user-delete/{id}', [UserController::class, "destroy"])->name('user-delete');
Route::get('/myProfile', [UserController::class, "myProfile"])->name('myProfile');
Route::get('/changePassword', [UserController::class, "changePassword"])->name('changePassword');
Route::post('/change_password_stote', [UserController::class, "change_password_stote"])->name('change_password_stote');

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
Route::get('/pdf_agent_statement/{id}', [AgentRecordController::class, "pdf_agent_statement"])->name('pdf_agent_statement');


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

// towards category
Route::get('/towards-category-list', [SaleCategoryController::class, "towards_index"])->name('towards-category-list');
Route::get('/towards-category', [SaleCategoryController::class, "towards_create"])->name('towards-category');
Route::post('/towards-category-save', [SaleCategoryController::class, "towards_store"])->name('towards-category-save');
Route::get('/towards-category-edit/{id}', [SaleCategoryController::class, "towards_edit"])->name('towards-category-edit');
Route::post('/towards-category-update/{id}', [SaleCategoryController::class, "towards_update"])->name('towards-category-update');
Route::get('/towards-category-delete/{id}', [SaleCategoryController::class, "towards_destroy"])->name('towards-category-delete');

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

// Debit Bill
Route::get('/debit-bill', [BillCollectionController::class, "debit_bill_index"])->name('debit-bill');
Route::post('/debit-bill-save', [BillCollectionController::class, "debit_bill_store"])->name('debit-bill-save');
Route::post('/debit_bill_row_data', [BillCollectionController::class, "edit"])->name('debit_bill_row_data');
Route::post('/debit_bill_delete', [BillCollectionController::class, "bill_collection_delete"])->name('debit_bill_delete');
Route::post('/get_debit_bill_list_data', [BillCollectionController::class, "get_debit_bill_list_data"])->name('get_debit_bill_list_data');

Route::post('/agent_debit_bill_payment_data', [BillCollectionController::class, "agent_debit_bill_payment_data"])->name('debit_bill_payment_data');

// Bill Refund
Route::get('/bill-refund', [BillCollectionController::class, "bill_refund"])->name('bill-refund');
Route::post('/bill-refund-save', [BillCollectionController::class, "bill_refund_save"])->name('bill-refund-save');
Route::post('/bill_refund_row_data', [BillCollectionController::class, "bill_refund_row_data"])->name('bill_refund_row_data');
Route::post('/bill_refund_delete', [BillCollectionController::class, "bill_refund_delete"])->name('bill_refund_delete');
Route::post('/get_bill_refund_list_data', [BillCollectionController::class, "get_bill_refund_list_data"])->name('get_bill_refund_list_data');

// Statement report
Route::get('/statement-report', [ReportController::class, "index"])->name('statement-report');
Route::post('/get_statement_report_data', [ReportController::class, "get_statement_report_data"])->name('get_statement_report_data');

// Agent date wise Statement
Route::get('/agent-date-wise-statement', [ReportController::class, "agent_date_wise_statement"])->name('agent-date-wise-statement');
Route::post('/get_agent_date_wise_statement_data', [ReportController::class, "get_agent_date_wise_statement_data"])->name('get_agent_date_wise_statement_data');
Route::get('/agent_date_wise_statement_pdf/{id}/{from_date}/{to_date}', [ReportController::class, "agent_date_wise_statement_pdf"])->name('agent_date_wise_statement_pdf');

// Account Wise report
Route::get('/account-report', [BankController::class, "account_report"])->name('account-report');
Route::post('/get_account_report_data', [BankController::class, "get_account_report_data"])->name('get_account_report_data');

// pdf

Route::get('/salesInvoicePdf/{id}', [SaleController::class, "salesInvoicePdf"])->name('salesInvoicePdf');

Route::post('/agentStatementAction', [ReportController::class, "agentStatementAction"])->name('agentStatementAction');
Route::post('/dailyStatementAction', [ReportController::class, "dailyStatementAction"])->name('dailyStatementAction');

// Acl  menu 
Route::get('/acl-menu-list', [AclMenuRoleController::class, 'index'])->name('menu.list');
Route::get('/acl-menu/create', [AclMenuRoleController::class, 'create'])->name('menu.create');
Route::post('/acl-menu/store', [AclMenuRoleController::class, 'store'])->name('menu.store');
Route::get('/acl-menu/edit/{id}', [AclMenuRoleController::class, 'edit'])->name('menu.edit');
Route::post('/acl-menu/update/{id}', [AclMenuRoleController::class, 'update'])->name('menu.update');
Route::get('/acl-menu/delete/{id}', [AclMenuRoleController::class, 'destroy'])->name('menu.delete');

// Acl Role

Route::get('/acl-role-list', [AclMenuRoleController::class, 'role_list'])->name('role.list');
Route::get('/acl-role/create', [AclMenuRoleController::class, 'role_create'])->name('role.role_create');
Route::post('/acl-role/store', [AclMenuRoleController::class, 'role_store'])->name('role.role_store');
Route::get('/acl-role/edit/{id}', [AclMenuRoleController::class, 'role_edit'])->name('role.role_edit');
Route::post('/acl-role/update/{id}', [AclMenuRoleController::class, 'role_update'])->name('role.role_update');
Route::get('/acl-role/delete/{id}', [AclMenuRoleController::class, 'role_destroy'])->name('role.role_delete');


Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";
});


