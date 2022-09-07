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

//user frontend route
Route::get('/', function () {
    return Redirect::to('admin/dashboard');
})->name('user.main');

Route::get('createcaptcha', 'CaptchaController@create');
Route::post('captcha', 'CaptchaController@captchaValidate');
Route::get('refreshcaptcha', 'CaptchaController@refreshCaptcha')->name('refresh.captcha');

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/verify/{id}', 'Api\VerifyController@index');

//api part

//get orderbook
Route::post('/getOrderBook', 'Api\CryptoController@getOrderBook');

//get the ticker
Route::post('/getTicker', 'Api\CryptoController@getTicker');

Route::post('/getProfit', 'Api\CryptoController@getProfit');

//get the exchange sets
Route::post('/getExchangeSets', 'Api\CryptoController@getExchangeSets');

//get the baseCurrency sets
Route::post('/getBaseCurrency', 'Api\CryptoController@getBaseCurrency');

// get the quoteCurrency sets
Route::post('/getQuoteCurrency', 'Api\CryptoController@getQuoteCurrency');

//end of api

//admin panel route
Route::prefix('admin')->group(function() {
    Route::get('/', function(){
        return Redirect::to('admin/dashboard');
    })->name('admin.index');

    /* Admin Auth Routes */
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    /* Admin Dashboard Routes */
    Route::get('/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');

    // Change Password Routes...
    $this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
    $this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');



    // Profile Page
    Route::get('/getprofile', 'Admin\userProfileController@show');
    Route::post('/profile', 'Admin\userProfileController@update');
    // end of profile


}) ;
//end
