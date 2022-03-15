<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

Route::get('signup', 'UserController@create')->name('signup');

Route::resource('users', 'UserController');

Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login');
Route::delete('logout', 'SessionController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UserController@confirmEmail')->name('confirm_email');

Route::get('password/rest', 'PasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email',  'PasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'PasswordController@showResetForm')->name('password.reset');
Route::post('password/reset',  'PasswordController@reset')->name('password.update');

Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy', 'edit', 'update']]);

//追蹤者列表 粉絲列表路由
Route::get('/users/{user}/followings', 'UserController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UserController@followers')->name('users.followers');

//追蹤用戶
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
//取消追蹤
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');
