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

   ############################## Categories Routes #########################
Route::group(['prefix'=>'Main_Categories'],function(){

 Route::get('/','MainCategoriesController@index')->name('admin.maincategories');
 Route::get('create','MainCategoriesController@create')->name('admin.maincategories.create');
 Route::post('store','MainCategoriesController@store')->name('admin.maincategories.store');
 Route::get('edit/{id}','MainCategoriesController@edit')->name('admin.maincategories.edit');
 Route::post('update/{id}','MainCategoriesController@update')->name('admin.maincategories.update');
 Route::get('delete/{id}','MainCategoriesController@destroy')->name('admin.maincategories.delete');
});

 ############################## Sub Categories Routes #########################
Route::group(['prefix'=>'Sub_Categories'],function(){

 Route::get('/','SubCategoriesController@index')->name('admin.subcategories');
 Route::get('create','SubCategoriesController@create')->name('admin.subcategories.create');
 Route::post('store','SubCategoriesController@store')->name('admin.subcategories.store');
 Route::get('edit/{id}','SubCategoriesController@edit')->name('admin.subcategories.edit');
 Route::post('update/{id}','SubCategoriesController@update')->name('admin.subcategories.update');
 Route::get('delete/{id}','SubCategoriesController@destroy')->name('admin.subcategories.delete');
});

 ############################## Brands Routes #########################
Route::group(['prefix'=>'brands'],function(){

 Route::get('/','BrandsController@index')->name('admin.brands');
 Route::get('create','BrandsController@create')->name('admin.brands.create');
 Route::post('store','BrandsController@store')->name('admin.brands.store');
 Route::get('edit/{id}','BrandsController@edit')->name('admin.brands.edit');
 Route::post('update/{id}','BrandsController@update')->name('admin.brands.update');
 Route::get('delete/{id}','BrandsController@destroy')->name('admin.brands.delete');
});









   ############################### End Categories ###########################







});


Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin' ,'prefix'=>'admin' ], function () {

    Route::get('login', 'loginController@login')->name('admin.login');
    Route::post('login', 'loginController@postLogin')->name('admin.post.login');
});


});

