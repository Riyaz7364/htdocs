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

Route::post('authreg', 'UserAuthController@signup')->name('usersignup');

Route::post('authlog', 'UserAuthController@login')->name('userlogin');

Route::post('authpasschange', 'UserAuthController@resetPassword')->name('changePass');

Route::get('confirm/{token}', 'UserAuthController@confirm');

Route::get('register', function () {
    return view('register');
});

Route::get('login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('index');

});
