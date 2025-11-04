<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
      'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
   ],
   function () {
      Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {
         Route::get('/', 'DashboardController@index')->name('admin.dashboard');
         Route::get('logout', 'loginController@logout')->name('admin.logout');


         Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shipping.methods');
         });

         Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
         });

         ############################## Categories Routes #########################
         Route::group(['prefix' => 'categories'], function () {

            Route::get('/', 'CategoriesController@index')->name('admin.categories');
            Route::get('create', 'CategoriesController@create')->name('admin.categories.create');
            Route::post('store', 'CategoriesController@store')->name('admin.categories.store');
            Route::get('edit/{id}', 'CategoriesController@edit')->name('admin.categories.edit');
            Route::post('update/{id}', 'CategoriesController@update')->name('admin.categories.update');
            Route::get('delete/{id}', 'CategoriesController@destroy')->name('admin.categories.delete');
         });




         ############################## Brands Routes #########################
         Route::group(['prefix' => 'brands'], function () {

            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@destroy')->name('admin.brands.delete');
         });


         ############################## TAGS Routes #########################
         Route::group(['prefix' => 'tags'], function () {

            Route::get('/', 'TagsController@index')->name('admin.tags');
            Route::get('create', 'TagsController@create')->name('admin.tags.create');
            Route::post('store', 'TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
            Route::post('update/{id}', 'TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'TagsController@destroy')->name('admin.tags.delete');
         });
         ############################### End Tags ###########################



         ############################## Products Routes #########################
         Route::group(['prefix' => 'products'], function () {

            Route::get('/', 'ProductController@index')->name('admin.products');
            Route::get('general-information', 'ProductController@create')->name('admin.products.general.create');
            Route::post('store-general-information', 'ProductController@store')->name('admin.products.general.store');
            Route::get('price/{id}', 'ProductController@setPrice')->name('admin.product.setprices');
            Route::post('price', 'ProductController@storePrice')->name('admin.product.prices');
            Route::get('stock/{id}', 'ProductController@setStock')->name('admin.product.setStock');
            Route::post('stock', 'ProductController@storeStock')->name('admin.product.stock');
         });
         ############################### End Tags ###########################







      });


      Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {

         Route::get('login', 'loginController@login')->name('admin.login');
         Route::post('login', 'loginController@postLogin')->name('admin.post.login');
      });
   }
);
