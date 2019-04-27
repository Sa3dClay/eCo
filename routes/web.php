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
Route::resource('reports', 'ReportController');
Route::resource('wishlist', 'wish_listController');
Route::resource('notifications', 'NotificationController');
Route::resource('invoice', 'InvoiceController');

Route::get('contact', 'ReportController@create');
Route::post('contact', 'ReportController@store');

Route::get('/wishlist/{id}/remove_from_wishlist', 'wish_listController@remove_from_WishList')->name('remove_from_wishList');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/products/{id}/change_visibilty', 'ProductsController@change_visibility')->name('change_visibilty');
//Route::get('/products/get_invisible', 'ProductsController@get_invisible')->name('get_invisible');
//Route::delete('/cart/{id}/remove_from_cart', 'CartController@remove_from_cart')->name('remove_from_cart');
Route::get('/cart/{id}/remove_from_cart', 'CartController@remove_from_cart')->name('remove_from_cart');
Route::get('/get_my_products', 'AdminDashboard@get_my_products')->name('get_my_products');
Route::post('/products/search', 'ProductsController@search')->name('search');

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
  Route::get('/get_invisible', 'AdminDashboard@get_invisible')->name('get_invisible');
  //Route::get('/get_my_products', 'AdminDashboard@get_my_products')->name('get_my_products');

  Route::post('/blockuser', 'AdminDashboard@blockUser');
  Route::post('/deleteuser', 'AdminDashboard@deleteUser');
});

// seller route
Route::group(['prefix' => 'dashboard/seller/', 'middleware' => ['admin']], function () {
  Route::get('/', 'SellerDashboard@index');
  //Route::get('/get_my_products', 'SellerDashboard@get_my_products')->name('get_my_products');
  // add products page to be added
});

// Test total cost
// Route::get('/total', 'CartController@getTotalCost');
