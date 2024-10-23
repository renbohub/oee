<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', 'App\Http\Controllers\AuthController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@loginAct')->name('login-post');
Route::get('/logout-action', 'App\Http\Controllers\AuthController@index')->name('logout');

Route::group(['middleware' => ['CheckSession']], function () {
    Route::get('/', 'App\Http\Controllers\AuthController@home')->name('home');

    Route::get('/accounting', 'App\Http\Controllers\Accountings\DashboardController@index')->name('accounting');
    Route::get('/purchase', 'App\Http\Controllers\AuthController@home')->name('purchase');
    Route::get('/project', 'App\Http\Controllers\AuthController@home')->name('project');

    Route::get('/warehouse', 'App\Http\Controllers\AuthController@home')->name('warehouse');
    // User Routes
    Route::get('/warehouse/product', 'App\Http\Controllers\warehouses\ProductController@index')->name('warehouse-product');
    Route::get('/warehouse/product/create', 'App\Http\Controllers\warehouses\ProductController@create')->name('warehouse-product-create');
    Route::post('/warehouse/product/store', 'App\Http\Controllers\warehouses\ProductController@store')->name('warehouse-product-store');
    Route::get('/warehouse/product/edit/{id}', 'App\Http\Controllers\warehouses\ProductController@edit')->name('warehouse-product-edit');
    Route::post('/warehouse/product/update/{id}', 'App\Http\Controllers\warehouses\ProductController@update')->name('warehouse-product-update');
    Route::get('/warehouse/product/delete/{id}', 'App\Http\Controllers\warehouses\ProductController@destroy')->name('warehouse-product-delete');

    Route::get('/setup', 'App\Http\Controllers\setups\SetupController@home')->name('setup');
    Route::get('/setup/company/edit', 'App\Http\Controllers\setups\SetupController@CompanyEdit')->name('company-edit');
    Route::post('/setup/company/edit/act', 'App\Http\Controllers\setups\SetupController@CompanyEditAct')->name('company-edit-act');

    // User Routes
    Route::get('/setup/user', 'App\Http\Controllers\setups\UsersController@index')->name('setup-user');
    Route::get('/setup/user/create', 'App\Http\Controllers\setups\UsersController@create')->name('setup-user-create');
    Route::post('/setup/user/store', 'App\Http\Controllers\setups\UsersController@store')->name('setup-user-store');
    Route::get('/setup/user/edit/{id}', 'App\Http\Controllers\setups\UsersController@edit')->name('setup-user-edit');
    Route::post('/setup/user/update/{id}', 'App\Http\Controllers\setups\UsersController@update')->name('setup-user-update');
    Route::get('/setup/user/delete/{id}', 'App\Http\Controllers\setups\UsersController@destroy')->name('setup-user-delete');

    // Apps Routes
    Route::get('/setup/app', 'App\Http\Controllers\setups\AppsController@index')->name('setup-app');
    Route::get('/setup/app/create', 'App\Http\Controllers\setups\AppsController@create')->name('setup-app-create');
    Route::post('/setup/app/create', 'App\Http\Controllers\setups\AppsController@store')->name('setup-app-store');
    Route::get('/setup/app/edit/{id}', 'App\Http\Controllers\setups\AppsController@edit')->name('setup-app-edit');
    Route::post('/setup/app/edit/{id}', 'App\Http\Controllers\setups\AppsController@update')->name('setup-app-update');
    Route::get('/setup/app/delete/{id}', 'App\Http\Controllers\setups\AppsController@destroy')->name('setup-app-delete');

    // Packages Routes
    Route::get('/setup/package', 'App\Http\Controllers\setups\PackagesController@index')->name('setup-package');
    Route::get('/setup/package/create', 'App\Http\Controllers\setups\PackagesController@create')->name('setup-package-create');
    Route::post('/setup/package/create', 'App\Http\Controllers\setups\PackagesController@store')->name('setup-package-store');
    Route::get('/setup/package/edit/{id}', 'App\Http\Controllers\setups\PackagesController@edit')->name('setup-package-edit');
    Route::post('/setup/package/edit/{id}', 'App\Http\Controllers\setups\PackagesController@update')->name('setup-package-update');
    Route::get('/setup/package/delete/{id}', 'App\Http\Controllers\setups\PackagesController@destroy')->name('setup-package-delete');

    // Roles Routes
    Route::get('/setup/role', 'App\Http\Controllers\setups\RolesController@index')->name('setup-role');
    Route::get('/setup/role/create', 'App\Http\Controllers\setups\RolesController@create')->name('setup-role-create');
    Route::post('/setup/role/create', 'App\Http\Controllers\setups\RolesController@store')->name('setup-role-store');
    Route::get('/setup/role/edit/{id}', 'App\Http\Controllers\setups\RolesController@edit')->name('setup-role-edit');
    Route::post('/setup/role/edit/{id}', 'App\Http\Controllers\setups\RolesController@update')->name('setup-role-update');
    Route::get('/setup/role/delete/{id}', 'App\Http\Controllers\setups\RolesController@destroy')->name('setup-role-delete');

    // Routes Routes
    Route::get('/setup/route', 'App\Http\Controllers\setups\RoutesController@index')->name('setup-route');
    Route::get('/setup/route/create', 'App\Http\Controllers\setups\RoutesController@create')->name('setup-route-create');
    Route::post('/setup/route/create', 'App\Http\Controllers\setups\RoutesController@store')->name('setup-route-store');
    Route::get('/setup/route/edit/{id}', 'App\Http\Controllers\setups\RoutesController@edit')->name('setup-route-edit');
    Route::post('/setup/route/edit/{id}', 'App\Http\Controllers\setups\RoutesController@update')->name('setup-route-update');
    Route::get('/setup/route/delete/{id}', 'App\Http\Controllers\setups\RoutesController@destroy')->name('setup-route-delete');

    // AppPermissions Routes
    Route::get('/setup/app_permission', 'App\Http\Controllers\setups\AppPermissionsController@index')->name('setup-app-permission');
    Route::get('/setup/app_permission/create', 'App\Http\Controllers\setups\AppPermissionsController@create')->name('setup-app-permission-create');
    Route::post('/setup/app_permission/create', 'App\Http\Controllers\setups\AppPermissionsController@store')->name('setup-app-permission-store');
    Route::get('/setup/app_permission/edit/{id}', 'App\Http\Controllers\setups\AppPermissionsController@edit')->name('setup-app-permission-edit');
    Route::post('/setup/app_permission/edit/{id}', 'App\Http\Controllers\setups\AppPermissionsController@update')->name('setup-app-permission-update');
    Route::get('/setup/app_permission/delete/{id}', 'App\Http\Controllers\setups\AppPermissionsController@destroy')->name('setup-app-permission-delete');

    // RoutePermissions Routes
    Route::get('/setup/route_permission', 'App\Http\Controllers\setups\RoutePermissionsController@index')->name('setup-route-permission');
    Route::get('/setup/route_permission/create', 'App\Http\Controllers\setups\RoutePermissionsController@create')->name('setup-route-permission-create');
    Route::post('/setup/route_permission/create', 'App\Http\Controllers\setups\RoutePermissionsController@store')->name('setup-route-permission-store');
    Route::get('/setup/route_permission/edit/{id}', 'App\Http\Controllers\setups\RoutePermissionsController@edit')->name('setup-route-permission-edit');
    Route::post('/setup/route_permission/edit/{id}', 'App\Http\Controllers\setups\RoutePermissionsController@update')->name('setup-route-permission-update');
    Route::get('/setup/route_permission/delete/{id}', 'App\Http\Controllers\setups\RoutePermissionsController@destroy')->name('setup-route-permission-delete');

    Route::get('/sales', 'App\Http\Controllers\Sales\DashboardController@index')->name('sales');
    Route::post('/sales', 'App\Http\Controllers\Sales\DashboardController@indexData')->name('sales-data');

    Route::get('/sales/quotation', 'App\Http\Controllers\Sales\QuotationController@index')->name('sales-quotation');
    Route::get('/sales/quotation/data', 'App\Http\Controllers\Sales\QuotationController@data')->name('sales-quotation-data');
    Route::post('/sales/quotation/create', 'App\Http\Controllers\Sales\QuotationController@create')->name('sales-quotation-create');
    Route::get('/sales/quotation/edit/{token}', 'App\Http\Controllers\Sales\QuotationController@edit')->name('sales-quotation-edit');
    Route::post('/sales/quotation/edit/header', 'App\Http\Controllers\Sales\QuotationController@editHeader')->name('sales-quotation-edit-head');
    Route::post('/sales/quotation/update', 'App\Http\Controllers\Sales\QuotationController@update')->name('sales-quotation-update');
    Route::get('/sales/quotation/delete/{token}', 'App\Http\Controllers\Sales\QuotationController@create')->name('sales-quotation-delete');
    Route::get('/sales/quotation/export/{token}', 'App\Http\Controllers\Sales\QuotationController@exportPdf')->name('sales-quotation-export');
    Route::post('/sales/quotation/update/status', 'App\Http\Controllers\Sales\QuotationController@updateStatus')->name('sales-quotation-update-status');

    Route::get('/sales/order', 'App\Http\Controllers\Sales\SalesOrderController@home')->name('sales-order');
    Route::post('/sales/order', 'App\Http\Controllers\Sales\SalesOrderController@post')->name('sales-order-post');
    Route::get('/sales/order/data', 'App\Http\Controllers\Sales\SalesOrderController@data')->name('sales-order-data');
    Route::get('/sales/order/{token}', 'App\Http\Controllers\Sales\SalesOrderController@edit')->name('sales-order-edit');
    Route::post('/sales/order/update/status', 'App\Http\Controllers\Sales\SalesOrderController@updateStatus')->name('sales-order-update-status');
    Route::post('/sales/order/header', 'App\Http\Controllers\Sales\SalesOrderController@editHeader')->name('sales-order-edit-header');
    Route::get('/sales/order/export/{token}', 'App\Http\Controllers\Sales\SalesOrderController@exportPdf')->name('sales-order-export');
    
    Route::get('/sales/delivery', 'App\Http\Controllers\AuthController@home')->name('sales-delivery');
    
    Route::get('/sales/invoice', 'App\Http\Controllers\Sales\InvoiceController@home')->name('sales-invoice');
    Route::post('/sales/invoice', 'App\Http\Controllers\Sales\InvoiceController@post')->name('sales-invoice-post');
    Route::get('/sales/invoice/data', 'App\Http\Controllers\Sales\InvoiceController@data')->name('sales-invoice-data');
    Route::get('/sales/invoice/{token}', 'App\Http\Controllers\Sales\InvoiceController@edit')->name('sales-invoice-edit');
    Route::post('/sales/invoice/header', 'App\Http\Controllers\Sales\InvoiceController@editHeader')->name('sales-invoice-edit-header');
    Route::post('/sales/invoice/update/status', 'App\Http\Controllers\Sales\InvoiceController@updateStatus')->name('sales-invoice-update-status');
    Route::get('/sales/invoice/export/{token}', 'App\Http\Controllers\Sales\InvoiceController@exportPdf')->name('sales-invoice-export');

    Route::get('/sales/customer', 'App\Http\Controllers\Sales\CustomerController@index')->name('sales-customer');
    Route::get('/sales/customer/create', 'App\Http\Controllers\Sales\CustomerController@create')->name('sales-customer-create');
    Route::post('/sales/customer/create', 'App\Http\Controllers\Sales\CustomerController@store')->name('sales-customer-store');
    Route::get('/sales/customer/edit/{id}', 'App\Http\Controllers\Sales\CustomerController@edit')->name('sales-customer-edit');
    Route::post('/sales/customer/edit/{id}', 'App\Http\Controllers\Sales\CustomerController@update')->name('sales-customer-update');
    Route::get('/sales/customer/delete/{id}', 'App\Http\Controllers\Sales\CustomerController@destroy')->name('sales-customer-delete');
});
