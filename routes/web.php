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
	Route::get('dashboard', 'DashboardController@dashboard'); //->name('dashboard');

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
	Route::post('upload-competitor-attachment', 'ProjectController@upload_competitor_attachment');
	Route::get('project-approval', 'ProjectController@project_approval');
	Route::get('approval-list', 'ApprovalController@approval_list');
	Route::patch('save-approval', 'ProjectController@save_approval');
	Route::get('/ajax-get-delivery-detail/{requirement_line_id}', 'DeliveryScheduleController@ajax_get_delivery_detail');
	Route::get('/ajax-get-projects/{customer_id}', 'PriceConfirmationController@ajax_get_projects');
	Route::post('ajax-cancel-project', 'ProjectController@ajax_cancel_project');
	Route::post('ajax-close-project', 'ProjectController@ajax_close_project');
	

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
	Route::post('save-fpc', 'PriceConfirmationController@save_fpc');
	Route::get('/ajax-get-freebies/{fpc_item_id}', 'PriceConfirmationController@ajax_get_freebies');
	Route::get('/ajax-delete-freebie/{fpc_item_id}', 'PriceConfirmationController@ajax_get_freebies');
	Route::post('ajax-save-fpc-item', 'PriceConfirmationController@ajax_save_fpc_item');
	Route::post('ajax-save-terms', 'PriceConfirmationController@ajax_save_terms');
	Route::post('ajax-approve-fpc', 'PriceConfirmationController@ajax_approve_fpc');
	Route::post('ajax-cancel-fpc', 'PriceConfirmationController@ajax_cancel_fpc');
	Route::get('print-fpc/{fpc_project_id}', 'PriceConfirmationController@print_fpc');
	
	/* FPC */
	Route::get('fpc-overview/{project_id}', 'PriceConfirmationController@fpc_overview');
	Route::get('ajax-get-fpc-details/{fpc_item_id}/{requirement_line_id}', 'PriceConfirmationController@ajax_get_fpc_details');
	Route::get('print-fpc-dealer/{print_type}/{project_id}/{fpc_id}/', 'PriceConfirmationController@print_fpc_dealer');

	/* Purchase Order */
	Route::get('po-overview/{action}/{po_header_id}', 'PurchaseOrderController@po_overview');
	Route::get('po-overview/{action}/{po_header_id}/{approval_id}', 'PurchaseOrderController@po_overview');
	Route::get('all-po', 'PurchaseOrderController@all_po');
	Route::get('po-approval', 'PurchaseOrderController@po_approval');
	Route::get('submit-po/{project_id}', 'PurchaseOrderController@submit_po');
	Route::post('save-po', 'PurchaseOrderController@save_po');
	Route::post('upload-po-attachment', 'PurchaseOrderController@upload_po_attachment');
	Route::post('save-po-validation', 'PurchaseOrderController@save_po_validation');

	/* Vehicle */
	Route::get('get-vehicle-models/{vehicle_type}', 'VehicleController@get_vehicle_models');
	Route::get('get-vehicle-colors/{sales_model?}', 'VehicleController@get_vehicle_colors')->where('sales_model', '(.*)');
	
	// Approval
	Route::get('/ajax-get-approval-workflow/{project_id}', 'ApprovalController@ajax_get_approval_workflow');

	//Competitors
	Route::get('/ajax-get-competitor-brands/', 'CompetitorController@ajax_get_competitor_brands');
	Route::get('/ajax-get-competitor-models/', 'CompetitorController@ajax_get_competitor_models');
	
	// FWPC
	Route::get('sales-order/{sales_order_number}/{dealer_id}', 'SalesOrderController@get_so_details');
	Route::post('sales-order', 'FWPCController@add_fwpc');
	Route::get('fwpc/{project_id}', 'FWPCController@get_fwpc_list');
	Route::delete('fwpc/{fwpc_id}', 'FWPCController@destroy');
	Route::get('sales-order-data/{fwpc_id}', 'SalesOrderController@sales_order_data');
	Route::get('print-fwpc/{fwpc_id}', 'FWPCController@print_fwpc');

	//
	Route::get('send-notification' , 'EmailController@send_notification');
});

Route::get('login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('logout', 'Auth\LogoutController@logout')->name('api_logout');