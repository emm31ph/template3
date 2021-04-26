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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', 'Auth\UserController@current');
    Route::patch('settings/profile', 'Auth\UserController@update');
    // Route::patch('settings/password', [PasswordController::class, 'update']);

    Route::group(['prefix' => 'items', 'as' => 'item'], function () {
        Route::post('import', 'Api\ItemController@import')->name('-import');
        Route::get('/getitems', 'Api\ItemBranchController@getItems')->name('-all');
        Route::get('/getAllitems', 'Api\ItemBranchController@getAllItems');

        // Route::get('/search', 'Api\Inventory\ItemController@search')->name('search');
        // Route::get('/getallitems', 'Api\Inventory\ItemController@getAllitems')->name('getallitems');
        Route::post('/dlvry-trans', 'Api\ItemController@DeliveryTrans')->name('-DeliveryTrans');
    });

    Route::group(['prefix' => 'branches', 'as' => 'branch'], function () {
        Route::get('getbranch', 'Api\BranchController@index');
    });

});
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
});
