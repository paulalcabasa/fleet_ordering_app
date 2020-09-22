<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::get('sales_order/{sales_order_number}', 'SalesOrderController@get_so_details');

// ----------------- Authentication ----------------- //

// -------------- End of authentication -------------- //

Route::post('export-inquiry', 'ReportsController@export_inquiry_history')->name('reports.export_inquiry');
Route::post('export-fpc-summary', 'ReportsController@export_fpc_summary')->name('reports.export_fpc_summary');

Route::get('fpc/project/print/{fpc_project_id}', 'PriceConfirmationController@print_fpc');
Route::get('fpc/print/dealer/{fpc_project_id}', 'PriceConfirmationController@print_fpc_dealer_v2');

Route::get('fpc/approve/{approval_id}', 'FPCController@approve');
Route::get('fpc/reject/{approval_id}', 'FPCController@reject');
Route::post('fpc/reject-fpc/{approval_id}', 'FPCController@processReject');
Route::get('fpc/inquiry/{approval_id}', 'FPCController@inquiry');
Route::post('fpc/inquiry-fpc/{approval_id}', 'FPCController@processInquiry');