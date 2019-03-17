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
    Route::get('/', 'InventoryController@home')->name('home');
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
    
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/addToCart', 'CartController@addToCart')->name('addToCart');
        Route::get('/cart', 'CartController@cartPage')->name('cart');
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/inventory', 'InventoryController@inventory')->name('inventory');
            Route::get('/manageUsers', 'UsersController@manageUsersPage')->name('manageUsers');
            Route::post('/updateUser', 'UsersController@updateUser')->name('updateUser');
        });
    });
});
