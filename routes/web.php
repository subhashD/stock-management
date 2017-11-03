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

Auth::routes();
Route::get('/home', 'PageController@getHome')->name('home');

//FormController
Route::post('/saveSettings','FormController@postSettings');
Route::post('/save_godown','FormController@postGodown');
Route::post('/save_product','FormController@postProduct');
Route::post('/add_stock','FormController@postStock');
Route::post('/add_vendor','FormController@postVendor');
Route::post('/saveCustomer','FormController@saveCustomer');
Route::post('/updateClient','FormController@updateClient');
Route::post('/migrate_stock','FormController@migrateStock');

//PageController
Route::get('/','PageController@getHome');
Route::get('/setting','PageController@getSetting');
Route::get('/new_client','PageController@getNewClient');
Route::get('/all_client','PageController@getAllClient');
Route::get('/vendors','PageController@getNewVendor');
Route::get('/godown','PageController@getNewGodown');
Route::get('/new_estimation','PageController@getNewEstimation');
Route::get('/godown','PageController@getGodown');
Route::get('/inventory','PageController@getInventory');
Route::get('/inventory_log','PageController@getInventoryLog');

//ajaxcontroller
Route::get('/deleteGodown/{id}','AjaxController@deleteGodown');
Route::get('/deleteProduct/{id}','AjaxController@deleteProduct');
Route::get('/getProductDesc/{id}','AjaxController@getProductDesc');
Route::get('/getCity/{state}','AjaxController@getCity');
Route::get('/deleteVendor/{id}','AjaxController@deleteVendor');
Route::get('/getVendor/{id}','AjaxController@getVendor');
Route::get('/edit_client/{id}','AjaxController@editClient');
Route::get('/deleteClient/{id}','AjaxController@deleteClient');

//InvoiceController
Route::get('/pending_inv','InvoiceController@getPendingInvoice');
Route::get('/paid_inv','InvoiceController@getPaidInvoice');
Route::get('/gst_payments','InvoiceController@getGSTInvoice');
Route::get('/non_gst_payments','InvoiceController@getNonGstInvoice');
Route::post('/new_invoice','InvoiceController@getNewInvoice');
Route::post('/saveInvoice','InvoiceController@saveInvoice');
Route::get('/getClientInvoice/{id}','InvoiceController@getClientInvoice');
Route::post('/payInvoice','InvoiceController@payInvoice');
Route::post('/deleteInvoice','InvoiceController@deleteInvoice');
Route::get('/editInvoice/{id}','InvoiceController@editInvoice');
Route::get('/invoicePdf/{id}','InvoiceController@invoicePdf');
Route::post('/filterPending','InvoiceController@filterPending');
Route::post('/filterPaid','InvoiceController@filterPaid');


//EstimationController
Route::post('/new_estimation','EstimationController@new_estimation');
Route::get('/all_estimation','EstimationController@getAllEstimation');
Route::post('/saveEstimate','EstimationController@saveEstimate');
Route::get('/getClientEstimate/{id}','EstimationController@getClientEstimate');
Route::get('/editEstimate/{id}','EstimationController@editEstimate');
Route::post('/deleteEstimate','EstimationController@deleteEstimate');
Route::get('/convertInvoice/{id}','EstimationController@convertInvoice');
Route::post('/sendMail','EstimationController@sendMail');
Route::get('/report_est','EstimationController@report_est');
Route::get('/estimatePdf/{id}','EstimationController@estimatePdf');
Route::post('/filterEstimate','EstimationController@filterEstimate');
