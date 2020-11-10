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
	Route::get('customer-overview/{customer_id}', 'CustomerController@customer_overview');
	Route::get('manage-customer/{action}/{customer_id}', 'CustomerController@manage_customer');


	Route::get('/ajax_get_scope/', 'CustomerController@ajax_get_scope');
	Route::get('/ajax-get-customer-data/{customer_name}', 'CustomerController@ajax_get_customer_data');
	Route::get('/ajax-get-customers/', 'CustomerController@ajax_get_customers');
	Route::get('/get-customers-select2/', 'CustomerController@get_customers_select2');
	Route::get('/ajax-get-affiliates/', 'CustomerController@ajax_get_affiliates');

	Route::post('customer/get', 'CustomerController@get_customer_info');
	/*Route::get('view-customer/{customer_id}', 'CustomerController@view_customer');*/

	/* Projects */

	Route::post('project/update', 'ProjectController@update');
	Route::post('project/save', 'ProjectController@store');
	Route::post('project/submit', 'ProjectController@submit');
	Route::post('project/attachment/upload', 'ProjectController@upload_project_attachment');

	Route::get('manage-project/{action}', 'ProjectController@manage_project');
	Route::get('manage-project/{action}/{project_id}', 'ProjectController@manage_project');
	Route::get('get-project-details/{project_id}', 'ProjectController@get_project_details');
	Route::get('all-projects', 'ProjectController@all_projects');
	Route::get('project-overview/{action}/{project_id}', 'ProjectController@project_overview');
	Route::get('project-overview/{action}/{project_id}/{approval_id}', 'ProjectController@project_overview');
	Route::get('get-sales-person-detail/{sales_person_id}', 'SalesPersonController@get_sales_person_detail');


	Route::post('upload-competitor-attachment', 'ProjectController@upload_competitor_attachment');
	Route::get('project-approval', 'ProjectController@project_approval');
	Route::get('approval-list', 'ApprovalController@approval_list');
	Route::post('save-approval', 'ProjectController@save_approval');
	Route::get('/ajax-get-delivery-detail/{requirement_line_id}', 'DeliveryScheduleController@ajax_get_delivery_detail');
	
	Route::post('ajax-cancel-project', 'ProjectController@ajax_cancel_project');
	Route::post('ajax-close-project', 'ProjectController@ajax_close_project');
	Route::post('ajax-reopen-project', 'ProjectController@ajax_reopen_project');
	

	// FPC Creation
	Route::get('/ajax-get-projects/{customer_id}', 'PriceConfirmationController@ajax_get_projects');
	Route::get('fpc/projects/{customer_id}', 'FPCController@getProjects');
	Route::post('fpc/project/add','FPCController@addProject');
	/* Price Confirmation */
	Route::get('price-confirmation', 'PriceConfirmationController@price_confirmation_entry');
	Route::get('all-price-confirmation', 'PriceConfirmationController@all_price_confirmation');
	Route::get('price-confirmation-details/{price_confirmation_id}', 'PriceConfirmationController@price_confirmation_details');
	Route::get('price-confirmation-details/{action}/{price_confirmation_id}', 'PriceConfirmationController@price_confirmation_details');
	Route::get('manage-fwpc/{action}/{price_confirmation_id}', 'PriceConfirmationController@manage_fwpc');
	Route::get('all-fwpc', 'PriceConfirmationController@all_fwpc');
	Route::get('view-fpc/{price_confirmation_id}', 'PriceConfirmationController@view_fpc');

	Route::get('fpc-details/{action}/{fpc_id}', 'PriceConfirmationController@fpc_details');
	Route::post('save-fpc', 'PriceConfirmationController@save_fpc');
	Route::get('/ajax-get-freebies/{fpc_item_id}', 'PriceConfirmationController@ajax_get_freebies');
	Route::get('/ajax-delete-freebie/{fpc_item_id}', 'PriceConfirmationController@ajax_get_freebies');
	Route::post('ajax-save-fpc-item', 'PriceConfirmationController@ajax_save_fpc_item');
	Route::post('delete-freebie', 'PriceConfirmationController@delete_freebie');
	Route::post('ajax-save-terms', 'PriceConfirmationController@ajax_save_terms');
	Route::post('ajax-approve-fpc', 'PriceConfirmationController@ajax_approve_fpc');
	Route::post('ajax-cancel-fpc', 'PriceConfirmationController@ajax_cancel_fpc');
	Route::get('print-fpc/{fpc_project_id}', 'PriceConfirmationController@print_fpc');
	Route::post('update-suggested-date', 'DeliveryScheduleController@update_suggested_date');
	Route::get('ajax-get-filtered-projects', 'ProjectController@ajax_get_filtered_projects');
	Route::get('print-project/{project_id}', 'ProjectController@print_project');


	/* FPC */
	Route::get('fpc-overview/{project_id}', 'PriceConfirmationController@fpc_overview');
	Route::get('ajax-get-fpc-details/{fpc_item_id}/{requirement_line_id}', 'PriceConfirmationController@ajax_get_fpc_details');
	Route::get('print-fpc-dealer/{print_type}/{project_id}/{fpc_id}/', 'PriceConfirmationController@print_fpc_dealer');
	Route::get('print-fpc-conflict/{fpc_id}/', 'PriceConfirmationController@print_fpc_conflict');
	Route::get('get-filtered-fpc', 'PriceConfirmationController@get_filtered_fpc');
	Route::patch('fpc/revise', 'PriceConfirmationController@revise');
	Route::patch('fpc/submit', 'PriceConfirmationController@submit');
	Route::get('fpc-approval', 'FPCController@fpc_approval')->name('fpc_approval');
	Route::get('fpc/approval/{approval_id}', 'FPCController@viewFPC');

	Route::get('fpc/approve/{approval_id}', 'FPCController@approve');


	/* Purchase Order */
	Route::get('po-overview/{action}/{po_header_id}', 'PurchaseOrderController@po_overview');
	Route::get('po-overview/{action}/{po_header_id}/{approval_id}', 'PurchaseOrderController@po_overview');
	Route::get('all-po', 'PurchaseOrderController@all_po');
	Route::get('po-approval', 'PurchaseOrderController@po_approval');
	Route::get('submit-po/{project_id}', 'PurchaseOrderController@submit_po');
	Route::post('save-po', 'PurchaseOrderController@save_po');
	Route::post('upload-po-attachment', 'PurchaseOrderController@upload_po_attachment');
	Route::post('save-po-validation', 'PurchaseOrderController@save_po_validation');
	Route::get('ajax-get-filtered-po', 'PurchaseOrderController@get_filtered_po');
	Route::get('po/get-fpc-lines/{fpc_project_id}', 'PurchaseOrderController@get_fpc_lines');

	/* Vehicle */
	Route::get('get-vehicle-models/{vehicle_type}', 'VehicleController@get_vehicle_models');
	Route::get('get-vehicle-colors/{sales_model?}', 'VehicleController@get_vehicle_colors')->where('sales_model', '(.*)');
	Route::get('vehicle/color/{sales_model?}', 'VehicleController@getVehicleColorWithPrice')->where('sales_model', '(.*)');
	
	// Approval
	Route::get('/ajax-get-approval-workflow/{project_id}', 'ApprovalController@ajax_get_approval_workflow');
	Route::post('approval/resend', 'ApprovalController@resend');

	//Competitors
	Route::get('/ajax-get-competitor-brands/', 'CompetitorController@ajax_get_competitor_brands');
	Route::get('/ajax-get-competitor-models/', 'CompetitorController@ajax_get_competitor_models');
	
	// FWPC
	Route::get('sales-order/{sales_order_number}/{dealer_id}', 'SalesOrderController@get_so_details');
	Route::post('sales-order', 'FWPCController@add_fwpc');
	Route::get('fwpc/{project_id}', 'FWPCController@get_fwpc_list');
	Route::post('delete-fwpc', 'FWPCController@delete_fwpc');
	Route::get('sales-order-data/{fwpc_id}', 'SalesOrderController@sales_order_data');
	Route::get('print-fwpc/{fwpc_id}', 'FWPCController@print_fwpc');
	Route::post('upload-fwpc-doc', 'FWPCController@upload_fwpc_doc');
	Route::post('validate-fwpc', 'FWPCController@validate_fwpc');
	Route::get('fwpc-list', 'FWPCController@fwpc_list')->name('fwpc_list');
	Route::get('get-all-fwpc', 'FWPCController@get_all_fwpc');

	// EMAIL NOTIFICATION
	Route::get('send-notification' , 'EmailController@send_notification');

	// USERS SETUP
	Route::get('user-list' , 'UserController@user_list');
	Route::get('ajax-get-user-approver' , 'UserController@ajax_get_approver');
	Route::delete('user-approver/{approver_id}' , 'UserController@delete_approver');
	Route::post('save-user-approver' , 'UserController@save_user_approver');
	Route::delete('delivery-schedule/{delivery_schedule_id}' , 'DeliveryScheduleController@deleteSchedule');
	Route::post('save-schedule' , 'DeliveryScheduleController@saveSchedule');
	Route::post('save-po-schedule' , 'DeliveryScheduleController@savePOSchedule');
	Route::delete('delete-requirement/{requirement_line_id}' , 'RequirementController@deleteRequirement');
	Route::post('cancel-fpc-project' , 'PriceConfirmationController@cancelFPCProject');

	// out of office
	Route::post('out-of-office/save', 'OutOfficeController@store');
	Route::get('out-of-office' , 'OutOfficeController@index');
	Route::get('out-of-office/{id}' , 'OutOfficeController@show');
	Route::get('out-of-office/update/{id}' , 'OutOfficeController@update');
	Route::delete('out-of-office/{id}' , 'OutOfficeController@destroy');
	Route::put('out-of-office/update' , 'OutOfficeController@update');

	
	// APPROVERS
	Route::get('approver-list' , 'ApproverController@approver_list');
	Route::post('add-approver' , 'ApproverController@add_approver');
	Route::post('update-approver-status' , 'ApproverController@update_approver_status');
	Route::post('update-approver' , 'ApproverController@update_approver');
	Route::get('get-approvers' , 'ApproverController@get_approvers');

	// PRICELIST
	Route::get('all-pricelist' , 'PriceListController@all_pricelist');
	Route::post('add-pricelist' , 'PriceListController@add_pricelist');
	Route::get('pricelist-details/{pricelist_header_id}' , 'PriceListController@pricelist_details');
	Route::post('add-vehicle-price' , 'PriceListController@add_pricelist_line');
	Route::get('get-pricelist-lines/{pricelist_header_id}' , 'PriceListController@get_pricelist_lines');
	Route::get('get-vehicle-price' , 'PriceListController@get_vehicle_price');

	// VALIDITY REQUEST
	Route::post('save-fpc-extension-request' , 'PriceConfirmationController@save_fpc_extension');

	// REPORTS
	Route::view('inquiry-history','reports.inquiry_history'); //->name('dashboard');
	Route::post('export-inquiry', 'ReportsController@export_inquiry_history')->name('export_inquiry');
	Route::get('fpc-summary', 'ReportsController@fpc_summary_view');//->name('fpc-summary');
	
	// Payment terms
	Route::get('payment_terms','TermsController@index');
	Route::post('term/add','TermsController@store');
	Route::patch('term/update','TermsController@update');

	Route::get('reports/tagged','ReportsController@showTaggedUnits');
	Route::view('reports/invoice','reports.invoice');
	Route::get('invoice/get','ReportsController@showInvoices');
	
	// Vehicles
	Route::get('vehicles','InactiveVehicleController@index');
	Route::post('vehicle/add-inactive','InactiveVehicleController@store');
	Route::delete('vehicle/delete-inactive/{id}','InactiveVehicleController@destroy');

	// Dealer Principals
	Route::get('dealer-principals','DealerPrincipalController@index');
	Route::post('dealer-principal/add','DealerPrincipalController@store');
	Route::patch('dealer-principal/update','DealerPrincipalController@update');
	Route::delete('dealer-principal/delete/{principal_id}','DealerPrincipalController@destroy');
	
	// Value sets
	Route::get('value-sets','ValueSetController@index');
	Route::post('value-set/add','ValueSetController@store');
	Route::patch('value-set/update','ValueSetController@updateValueSet');
	Route::delete('value-set/delete/{value_set_id}','ValueSetController@destroy');

	// Oracle customers
	Route::post('customer/oracle/search', 'CustomerController@findOracleCustomer');
	Route::post('project/oracle-customer/update', 'ProjectController@updateOracleCustomer');
	
});

Route::get('login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('logout', 'Auth\LogoutController@logout')->name('api_logout');
