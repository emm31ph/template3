<?php

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

// Route::get('/getItemDetailTran', 'Api\ItemBranchController@getItemDetailTran');

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::get('unreadNotification', 'Auth\UserController@unreadNotification');
    Route::get('users', 'Auth\UserController@index');
    Route::patch('user/update', 'Auth\UserController@updateUser');
    Route::post('user/create', 'Auth\UserController@store');
    Route::delete('user/{user}', 'Auth\UserController@destroy');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', 'Auth\UserController@current');
    Route::patch('settings/profile', 'Auth\UserController@update');
    Route::patch('user/updateBranch', 'Auth\UserController@updateBranch');

    Route::apiResource('roles', 'Api\RolesController');
    Route::apiResource('permissions', 'Api\PermissionsController');

    Route::group(['prefix' => 'items', 'as' => 'item'], function () {
        Route::post('import', 'Api\ItemController@import')->name('-import');
        Route::get('importTrndate', 'Api\ItemController@importTrndate')->name('-importTrndate');

        Route::get('/getitems', 'Api\ItemBranchController@getItems')->name('-all');
        Route::get('/getTrnHist', 'Api\ItemBranchController@getTrnHist')->name('-trn');

        Route::any('/myTrn', 'Api\ItemBranchController@mytransaction')->name('-myTrn');

        Route::get('/getAllItems', 'Api\ItemBranchController@getAllItems');
        Route::get('/getAllitemsBranch', 'Api\ItemBranchController@getAllItemsBranch');
        Route::get('/getAllitemsBranchRRM', 'Api\ItemBranchController@getAllItemsBranchRRM');
        Route::get('/getItemsOut', 'Api\ItemBranchController@getItemsOut');
        Route::get('/getItemDetailTran', 'Api\ItemBranchController@getItemDetailTran');
        Route::get('/trnExportD', 'Api\ItemBranchController@trnExportD');

        Route::post('/dlvry-trans', 'Api\ItemController@DeliveryTrans')->name('-DeliveryTrans');
        Route::post('/cancel-trans', 'Api\ItemController@CancelTrans')->name('-CancelTrans');
        Route::post('/adj-trans', 'Api\ItemController@AdjustmentTrans')->name('-ADJTrans');
        Route::post('/fptd-trans', 'Api\ItemController@FPTDRJCTTrans')->name('-FptdTrans');
        Route::post('/reject-trans', 'Api\ItemController@RJCTTrans')->name('-RJCTTrans');

        Route::post('/rrm-trans', 'Api\ItemController@RRMTrans')->name('-RRMTrans');
        Route::post('/rr-trans', 'Api\ItemController@RRTrans')->name('-RRTrans');

        Route::get('/reportItem', 'Api\ItemBranchController@reportItem')->name('-Report');

        Route::post('/create', 'Api\ItemController@store')->name('create');
        Route::patch('/update', 'Api\ItemController@update')->name('update');
        Route::delete('/{itemcode}', 'Api\ItemController@destroy');

    });

    Route::group(['prefix' => 'branches', 'as' => 'branch'], function () {
        Route::get('getbranch', 'Api\BranchController@index');
    });

    Route::group(['prefix' => 'settings', 'as' => 'setting'], function () {
        Route::any('price', 'Settings\PriceController@price');  
        Route::any('customer', 'Settings\CustomerController@index'); 
        Route::any('lookup', 'Settings\LookupController@index'); 
        Route::any('signatories', 'Settings\SignatoriesController@index'); 
        Route::any('salesperson', 'Settings\SalesPersonController@index'); 
    });

    Route::group(['prefix' => 'invoice', 'as' => 'invoice'], function () { 
        Route::any('process', 'Invoices\InvoiceController@index'); 
    });
    Route::group(['prefix' => 'process', 'as' => 'process'], function () { 
        Route::any('logistic', 'Process\LogisticController@index'); 
    });

 

});
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
});
