<?php

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

/*Route::get('/', function () {
    return view('dashboard');
});*/

Route::get('/', 'RedirectController@redirect_login');

Route::middleware(['auth:oracle_users,web'])->group(function () { //--> Authenticated Users

	/* Dashboard */
	Route::view('dashboard', 'dashboard')->name('dashboard');

	/* Customers */
	Route::get('all-customers', 'CustomerController@all_customers');
	Route::get('new-customer', 'CustomerController@new_customer');

	/* Projects */
	Route::get('new-project', 'ProjectController@new_project');
	Route::get('all-projects', 'ProjectController@all_projects');

	/* Price Confirmation */
	Route::get('price-confirmation', 'PriceConfirmationController@price_confirmation_entry');
	Route::get('all-price-confirmation', 'PriceConfirmationController@all_price_confirmation');
	Route::get('price-confirmation-details/{price_confirmation_id}', 'PriceConfirmationController@price_confirmation_details');

	/* Purchase Order */
	Route::get('po-entry/{price_confirmation_id}', 'PurchaseOrderController@po_entry');
	Route::get('all-po', 'PurchaseOrderController@all_po');

});

// ----------------- Authentication ----------------- //
Route::get('api/login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('api/logout', 'Auth\LogoutController@logout')->name('api_logout');
// -------------- End of authentication -------------- //

