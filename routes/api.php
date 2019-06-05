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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'registerController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::get('customers', 'CustomersController@all');
    Route::get('customers/{id}', 'CustomersController@get');
    Route::post('customers/new', 'CustomersController@new');
});

    //inventory Routing using Controller
    Route::get('inventory', 'InventoryController@all');
    Route::post('inventory/new', 'InventoryController@new');
    Route::post('inventory/update/{itemcode}', 'InventoryController@update');
    Route::post('inventory/consignor', 'InventoryController@addConsignor');
    Route::delete('inventory/delete/{itemcode}', 'InventoryController@delete');
    Route::get('inventory/pickconsignor', 'InventoryController@pickConsignor');
    Route::get('inventory/{itemcode}', 'InventoryController@get');
    Route::get('inventory/getStock', 'InventoryController@getStock');
    
    //walkin Routing using Controller
    Route::get('pharmacy', 'WalkinController@all');
    Route::post('pharmacy/new', 'WalkinController@new');
    Route::get('pharmacy/newOrder', 'WalkinController@newOrder');
    Route::post('pharmacy/addItem/{itemcode}', 'WalkinController@showItem');

    //InPatient Routing using Controller
    Route::get('inPatient', 'InPatientController@all');
    Route::post('inPatient/new', 'InPatientController@new');
    Route::get('inPatient/getPatienInfo', 'InPatientController@getPatienInfo');
    Route::post('inPatient/admissionDetails', 'InPatientController@admissionDetails');

    Route::get('inPatient/getPersonal', 'InPatientController@getPersonal');
    Route::get('inPatient/getCurrent', 'InPatientController@getCurrent');
    Route::get('inPatient/getOrder', 'InPatientController@getOrder');
    Route::get('inPatient/getOrderName', 'InPatientController@getOrderName');
    Route::get('inPatient/newOrder', 'InPatientController@newOrder');
    Route::post('inPatient/addItem/{itemcode}', 'InPatientController@showItem');
    Route::post('inPatient/addOrder', 'InPatientController@addOrder');
    Route::get('inPatient/{inpatient_id}', 'InPatientController@ViewPatient');
    Route::post('inPatient/updatePersonal', 'InPatientController@updatePersonal');
    Route::post('inPatient/updateRecord', 'InPatientController@updateRecord');
    Route::post('inPatient/updateOrder', 'InPatientController@updateOrder');
    Route::delete('inPatient/deleteOrderItem', 'InPatientController@deleteOrderItem');
    // Route::post('inPatient/newdoctor', 'InPatientController@newdoctor');
    // Route::get('inPatient/pickDoctor', 'InPatientController@pickDoctor');
    // Route::post('inPatient/list', 'InPatientController@ListDoctor');
    // Route::post('inPatient/update', 'InPatientController@UpdatePatient');

    //Report Routing using Controller
    Route::get('report', 'ReportController@getDailyDate');
    Route::get('report/getMonthlyDate', 'ReportController@getMonthlyDate');
    Route::get('report/exportxlsv', 'ReportController@exportPdf');