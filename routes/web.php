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

Route::group(['middleware' => 'web'], function () {
    Route::match(['get', 'post'], '/', 'InventoryController@home')->name('home');
    Route::post('/getItems/{index?}', 'InventoryController@getItems')->name('getItems');

    Route::get('/forgotPassword', 'ForgotPasswordController@forgotPassword')->name('forgotPassword');
    Route::post('/forgotPassword', 'ForgotPasswordController@submitForgotPassword')->name('submitForgotPassword');

    Route::get('/resetPassword/{token}', 'ResetPasswordController@resetPassword')->name('resetPassword');
    Route::post('/resetPassword/{token}', 'ResetPasswordController@submitResetPassword')->name('submitResetPassword');

    Auth::routes();

    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login', 'LoginController@submitLogin')->name('submitLogin');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/register', 'RegisterController@register')->name('register');
    Route::post('/register', 'RegisterController@submitRegister')->name('submitRegister');

    Route::get('/item/{modelNumber}', 'InventoryController@getDescription')->name('getDescription');
    

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/getTotal', 'CartController@getTotal')->name('getTotal');
        Route::post('/addToCart', 'CartController@addToCart')->name('addToCart');
        Route::post('/removeFromCart', 'CartController@removeFromCart')->name('removeFromCart');
        Route::get('/cart', 'CartController@cartPage')->name('cart');
        Route::post('/checkout', 'CartController@checkout')->name('checkout');
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/inventory', 'InventoryController@inventory')->name('inventory');

            Route::get('/manageUsers', 'UsersController@manageUsersPage')->name('manageUsers');
            Route::post('/updateUser', 'UsersController@updateUser')->name('updateUser');
            Route::post('/deleteUser', 'UsersController@deleteUser')->name('deleteUser');

            Route::get('/itemForm/{modelNumber?}', 'InventoryController@itemForm')->name('itemForm');
            Route::post('/createItem', 'InventoryController@createItem')->name('createItem');
            Route::post('/updateItem', 'InventoryController@updateItem')->name('updateItem');
            Route::post('/deleteItem', 'InventoryController@deleteItem')->name('deleteItem');
            Route::post('/deleteFile', 'InventoryController@deleteFile')->name('deleteFile');
        });
    });
});
