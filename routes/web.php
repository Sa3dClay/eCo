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

Route::get('/', 'PagesController@index')->name('welcome');

Route::resource('products', 'ProductsController');
Route::resource('cart', 'CartController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/products/{id}/change_visibilty', 'ProductsController@change_visibility')->name('change_visibilty');
Route::delete('/Cart/{id}/remove_from_cart', 'CartController@remove_from_cart')->name('remove_from_cart');
Route::get('/products/{strword}/search', 'ProductsController@search')->name('search');
// admins authentication
Route::group(['prefix' => 'dashboard'], function () {
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

// admin route
Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['admin']], function () {
  Route::get('/', 'AdminDashboard@index');
  Route::get('/addmember', 'AdminDashboard@showRegister')->name('register');
  Route::post('/addmember', 'AdminDashboard@addMembers');

  Route::get('/users', 'AdminDashboard@showUsers');

  Route::post('/blockuser', 'AdminDashboard@blockUser');
  Route::post('/deleteuser', 'AdminDashboard@deleteUser');
});

// seller route
Route::group(['prefix' => 'dashboard/seller/', 'middleware' => ['admin']], function () {
  Route::get('/', 'SellerDashboard@index');
  // add products page to be added
});
