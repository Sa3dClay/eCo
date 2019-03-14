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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('products', 'ProductsController');
Route::resource('cart', 'CartController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/',function(){
    return view('welcome');
})->name('welcome');

// admin route
Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'admin/'], function () {
  Route::get('/', 'AdminDashboard@index');
});


// seller route
Route::group(['prefix' => 'seller'], function () {
  Route::get('/login', 'SellerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'SellerAuth\LoginController@login');
  Route::post('/logout', 'SellerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'SellerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'SellerAuth\RegisterController@register');

  Route::post('/password/email', 'SellerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'SellerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'SellerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'SellerAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'seller/'], function () {
  Route::get('/', 'SellerDashboard@index');
});
