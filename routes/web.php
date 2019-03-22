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

Route::get('/', 'IndexController@index');

Route::get('/logout', 'AdminController@logout');

//List
Route::get('/products/{id}', 'ProductsController@products');

//Detail
Route::get('/product/{id}', 'ProductsController@product');

//Cart
Route::match(['get', 'post'], '/cart','ProductsController@cart');
Route::match(['get', 'post'], '/add-cart','ProductsController@addToCart');
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');

//Get Product Attribute Price 
Route::get('/get-product-price', 'ProductsController@getProductPrice');

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
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}','ProductsController@editAttributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

    //Product Alt Images
    Route::match(['get', 'post'], '/admin/add-images/{id}','ProductsController@addImages');
    Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteProductAltImage');
});

Route::get('/home', 'HomeController@index')->name('home');
