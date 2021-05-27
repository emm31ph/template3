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

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('users', 'Auth\UserController@index');
    Route::patch('user/update', 'Auth\UserController@updateUser');
    Route::post('user/create', 'Auth\UserController@store');
    Route::delete('user/{user}', 'Auth\UserController@destroy');

    Route::get('roles', 'Api\RolesController@index');

    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', 'Auth\UserController@current');
    Route::patch('settings/profile', 'Auth\UserController@update');
    // Route::patch('settings/password', [PasswordController::class, 'update']);

    Route::group(['prefix' => 'items', 'as' => 'item'], function () {
        Route::post('import', 'Api\ItemController@import')->name('-import');
        Route::get('/getitems', 'Api\ItemBranchController@getItems')->name('-all');
        Route::get('/getTrnHist', 'Api\ItemBranchController@getTrnHist')->name('-trn');

        Route::get('/getAllItems', 'Api\ItemBranchController@getAllItems');
        Route::get('/getAllitemsBranch', 'Api\ItemBranchController@getAllItemsBranch');
        Route::get('/getItemsOut', 'Api\ItemBranchController@getItemsOut');
        Route::get('/getItemDetailTran', 'Api\ItemBranchController@getItemDetailTran');

        Route::post('/dlvry-trans', 'Api\ItemController@DeliveryTrans')->name('-DeliveryTrans');
        Route::post('/fptd-trans', 'Api\ItemController@FPTDRJCTTrans')->name('-FptdTrans');
        Route::post('/reject-trans', 'Api\ItemController@RJCTTrans')->name('-RJCTTrans');

        Route::post('/rrm-trans', 'Api\ItemController@RRMTrans')->name('-RRMTrans');
        Route::post('/rr-trans', 'Api\ItemController@RRTrans')->name('-RRTrans');

        Route::get('/reportItem', 'Api\ItemBranchController@reportItem')->name('-Report');

    });

    Route::group(['prefix' => 'branches', 'as' => 'branch'], function () {
        Route::get('getbranch', 'Api\BranchController@index');
    });

});
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
});
