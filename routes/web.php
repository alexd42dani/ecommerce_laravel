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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login', 'loginController@index')->name('login');
Route::post('/login', 'loginController@auth')->name('login.auth');

Route::get('/register', 'registerController@index')->name('register');
Route::post('/register', 'registerController@store')->name('register.store');

Route::get('/profile', 'profileControler@index')->name('profile');
Route::get('/profile/edit/', 'profileControler@edit')->name('profile.edit');
Route::put('/profile/{customer?}', 'profileControler@update')->name('profile.update');

Route::get('/index', 'indexController@index')->name('index');

Route::post('search', 'searchController@search')->name('search');

Route::get('shop', 'shopController@index')->name('shop');
Route::get('shop/{room?}', 'shopController@detail')->name('shop.detail');

Route::post('/cart_add', 'cartController@add')->name('cart.add');
Route::post('/cart_get', 'cartController@getCart')->name('cart.get');
Route::post('/cart_delete', 'cartController@delete')->name('cart.delete');

Route::get('/checkout', 'checkoutController@index')->name('checkout');
Route::post('/payment', 'checkoutController@payment')->name('checkout.payment');

Route::get('/logout', 'loginController@logout')->name('logout');

Route::get('/activate', 'registerController@activate')->name('activate');
/*
Route::fallback(function () {
    return view('error');
});*/

//ADMIN*****

Route::get('/admin/login', 'login_adminController@index')->name('login_admin');
Route::post('/admin/login', 'login_adminController@auth')->name('login_admin.auth');

Route::get('/admin/register', 'register_adminController@index')->name('register_admin');
Route::post('/admin/register', 'register_adminController@store')->name('register_admin.store');

Route::get('/admin/index', 'index_adminController@index')->name('index_admin');

Route::get('/logout_admin', 'login_adminController@logout')->name('logout_admin');

Route::get('/admin/users', 'users_adminController@index')->name('users_admin');
Route::get('/admin/users/edit/{admin?}', 'users_adminController@edit')->name('users_admin.edit');
Route::put('/admin/users/{admin?}', 'users_adminController@update')->name('users_admin.update');
Route::get('/admin/users/remove/{admin?}', 'users_adminController@destroy')->name('users_admin.destroy');

Route::get('/admin/ventas', 'ventas_adminController@index')->name('ventas_admin');

Route::get('/admin/rooms', 'rooms_adminController@index')->name('rooms_admin.index');
Route::get('/admin/rooms/add', 'rooms_adminController@create')->name('rooms_admin.create');
Route::post('/admin/rooms/add', 'rooms_adminController@store')->name('rooms_admin.store');
Route::get('/admin/rooms/edit/{room?}', 'rooms_adminController@edit')->name('rooms_admin.edit');
Route::put('/admin/rooms/{room?}', 'rooms_adminController@update')->name('rooms_admin.update');
Route::get('/admin/rooms/remove/{room?}', 'rooms_adminController@destroy')->name('rooms_admin.destroy');

Route::get('/admin/rooms_type', 'roomstype_adminController@index')->name('roomstype_admin.index');
Route::get('/admin/rooms_type/add', 'roomstype_adminController@create')->name('roomstype_admin.create');
Route::post('/admin/rooms_type/add', 'roomstype_adminController@store')->name('roomstype_admin.store');
Route::get('/admin/rooms_type/edit/{rooms_type?}', 'roomstype_adminController@edit')->name('roomstype_admin.edit');
Route::put('/admin/rooms_type/{rooms_type?}', 'roomstype_adminController@update')->name('roomstype_admin.update');
Route::get('/admin/rooms_type/remove/{rooms_type?}', 'roomstype_adminController@destroy')->name('roomstype_admin.destroy');

Route::get('/admin/chara', 'chara_adminController@index')->name('chara_admin.index');
Route::get('/admin/chara/add', 'chara_adminController@create')->name('chara_admin.create');
Route::post('/admin/chara/add', 'chara_adminController@store')->name('chara_admin.store');
Route::get('/admin/chara/edit/{characteristics?}', 'chara_adminController@edit')->name('chara_admin.edit');
Route::put('/admin/chara/{characteristics?}', 'chara_adminController@update')->name('chara_admin.update');
Route::get('/admin/chara/remove/{characteristics?}', 'chara_adminController@destroy')->name('chara_admin.destroy');

Route::get('/admin/image/add', 'page_adminController@create_image')->name('image.create');
Route::post('/admin/image/add', 'page_adminController@store_image')->name('image.store');

Route::get('/admin/recommended/add', 'page_adminController@create_recommended')->name('recommended.create');
Route::post('/admin/recommended/add', 'page_adminController@store_recommended')->name('recommended.store');

Route::get('/admin/calendar', 'calendar_adminController@index')->name('calendar.index');
Route::post('/admin/calendar', 'calendar_adminController@index_')->name('calendar.index_');
