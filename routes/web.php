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
});

Route::match(['get', 'post'], '/admin', 'AdminController@login' );

Auth::routes();



Route::get('/logout', 'AdminController@logout');

Route::group(['middleware' => ['auth']], function(){
	Route::get('/admin/dashboard', 'AdminController@dashboard');
	Route::get('/admin/setting', 'AdminController@setting');
	Route::get('/admin/check-pwd', 'AdminController@chkPassword');
	Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

	//Category Routes
	Route::match(['get', 'post'], '/admin/add-category','CategoryController@addCategory');
	Route::match(['get', 'post'], '/admin/edit-category/{id}','CategoryController@editCategory');
	Route::match(['get', 'post'], '/admin/delete-category/{id}','CategoryController@deleteCategory');
	Route::get('/admin/view-category', 'CategoryController@viewCategories');

	//Product Routes
	Route::match(['get', 'post'], '/admin/add-product','ProductsController@addProduct');
	Route::match(['get', 'post'], '/admin/edit-product/{id}','ProductsController@editProducts');
	Route::get('/admin/view-product', 'ProductsController@viewProducts');
	Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    
    //Product Attribute
    Route::match(['get', 'post'], '/admin/add-attributes/{id}','ProductsController@addAttributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');
});

Route::get('/home', 'HomeController@index')->name('home');
