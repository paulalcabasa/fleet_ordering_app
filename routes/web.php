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
	Route::get('manage-customer/{action}', 'CustomerController@manage_customer');
	Route::get('manage-customer/{action}/{customer_id}', 'CustomerController@manage_customer');
	Route::get('/ajax_get_scope/', 'CustomerController@ajax_get_scope');
	Route::get('/ajax-get-customer-data/{customer_name}', 'CustomerController@ajax_get_customer_data');
	Route::get('/ajax-get-customers/', 'CustomerController@ajax_get_customers');
	Route::get('/ajax-get-affiliates/', 'CustomerController@ajax_get_affiliates');
	/*Route::get('view-customer/{customer_id}', 'CustomerController@view_customer');*/

	/* Projects */
	Route::get('manage-project/{action}', 'ProjectController@manage_project');
	Route::get('manage-project/{action}/{price_confirmation_id}', 'ProjectController@manage_project');
	Route::get('all-projects', 'ProjectController@all_projects');
	Route::get('project-overview/{action}/{project_id}', 'ProjectController@project_overview');
	Route::get('project-overview/{action}/{project_id}/{approval_id}', 'ProjectController@project_overview');
	Route::get('get-sales-person-detail/{sales_person_id}', 'SalesPersonController@get_sales_person_detail');
	Route::post('save-project', 'ProjectController@save_project');
	Route::post('upload-project-attachment', 'ProjectController@upload_project_attachment');
	Route::get('project-approval', 'ProjectController@project_approval');
	Route::post('save-approval', 'ProjectController@save_approval');
	
	

	/* Price Confirmation */
	Route::get('price-confirmation', 'PriceConfirmationController@price_confirmation_entry');
	Route::get('all-price-confirmation', 'PriceConfirmationController@all_price_confirmation');
	Route::get('price-confirmation-details/{price_confirmation_id}', 'PriceConfirmationController@price_confirmation_details');
	Route::get('price-confirmation-details/{action}/{price_confirmation_id}', 'PriceConfirmationController@price_confirmation_details');
	Route::get('manage-fwpc/{action}/{price_confirmation_id}', 'PriceConfirmationController@manage_fwpc');
	Route::get('all-fwpc', 'PriceConfirmationController@all_fwpc');
	Route::get('view-fpc/{price_confirmation_id}', 'PriceConfirmationController@view_fpc');
	Route::get('fpc-approval', 'PriceConfirmationController@fpc_approval');
	Route::get('fpc-details/{action}/{fpc_id}', 'PriceConfirmationController@fpc_details');

	/* Purchase Order */
	Route::get('manage-po/{action}/{price_confirmation_id}', 'PurchaseOrderController@manage_po');
	Route::get('all-po', 'PurchaseOrderController@all_po');
	Route::get('po-approval', 'PurchaseOrderController@po_approval');

	/* Vehicle */
	Route::get('get-vehicle-models/{vehicle_type}', 'VehicleController@get_vehicle_models');
	Route::get('get-vehicle-colors/{sales_model}', 'VehicleController@get_vehicle_colors');

});

// ----------------- Authentication ----------------- //
Route::get('api/login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('api/logout', 'Auth\LogoutController@logout')->name('api_logout');
// -------------- End of authentication -------------- //

