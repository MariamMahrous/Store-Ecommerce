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
//i added prefix ("admin") for all routes in RouteServiceProvider
  
Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ 
  Route::group([ 'prefix'=>'admin'  , 'namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {
  Route::get('/','DashboardController@index')->name('admin.dashboard');
 Route::get('logout', 'loginController@logout')->name('admin.logout');


  Route::group(['prefix'=>'settings'],function(){
       Route::get('shipping-methods/{type}','SettingsController@editShippingMethods')->name('edit.shipping.methods');
       Route::put('shipping-methods/{id}','SettingsController@updateShippingMethods')->name('update.shipping.methods');
      });

Route::group(['prefix'=>'profile'],function(){
       Route::get('edit','ProfileController@editProfile')->name('edit.profile');
       Route::put('update','ProfileController@updateProfile')->name('update.profile');
      });


});


Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin' ,'prefix'=>'admin' ], function () {

    Route::get('login', 'loginController@login')->name('admin.login');
    Route::post('login', 'loginController@postLogin')->name('admin.post.login');
});


});

