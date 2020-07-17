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
Route::get('/', 'HomeController@first')->name('first');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => '/companies'], function () {
        Route::get('/', 'CompanyController@index')->name('Company.index');
        Route::post('/', 'CompanyController@store')->name('Company.store');
        Route::get('/{id}', 'CompanyController@show')->name('Company.show');
        Route::patch('/{id}', 'CompanyController@update')->name('Company.update');
        Route::delete('/{id}', 'CompanyController@destroy')->name('Company.destroy');
        Route::post('/check','CompanyController@checkCompanyAvail')->name('Company.check');
        Route::patch('/link/{id}','CompanyController@linkCompany')->name('Company.link');
    });
    Route::get('/FAQ', 'HomeController@FAQ')->name('FAQ');
    Route::group(['prefix' => '/contacts'], function () {
        Route::get('/', 'ContactPersonController@index')->name('ContactPerson.index');
        Route::post('/', 'ContactPersonController@store')->name('ContactPerson.store');
        Route::get('/{id}', 'ContactPersonController@show')->name('ContactPerson.show');
        Route::patch('/{id}', 'ContactPersonController@update')->name('ContactPerson.update');
        Route::delete('/{id}', 'ContactPersonController@destroy')->name('ContactPerson.destroy');
    });
    
    Route::group(['prefix' => '/offers'], function () {
        Route::get('/', 'OfferController@index')->name('Offer.index');
        Route::get('/{name}', 'CompanyController@storeView')->name('Offer.index_view')->where('name', 'add');
        Route::post('/', 'OfferController@store')->name('Offer.store');
        Route::get('/edit/{id}', 'OfferController@editView')->name('Offer.update_view');
        Route::get('/{id}', 'OfferController@show')->name('Offer.show');
        Route::patch('/{id}', 'OfferController@update')->name('Offer.update');
        Route::delete('/{id}', 'OfferController@destroy')->name('Offer.destroy');
        Route::get('/ppn/{id}', 'OfferController@ppn')->name('Offer.PPN');
    });

    Route::group(['prefix' => '/products'], function () {
        Route::post('/', 'ProductController@store')->name('Product.store');
        Route::delete('/{id}', 'ProductController@destroy')->name('Product.destroy');
        Route::patch('/{id}', 'ProductController@update')->name('Product.update');
    });

    Route::middleware('admin')->group(function () {
        Route::group(['prefix' => '/admin'], function () {
            Route::get('/', 'AdminController@index')->name('Admin.index');
            Route::get('/restore', 'AdminController@restoreView')->name('Admin.restoreView');
            Route::patch('/restore/{id}', 'AdminController@restore')->name('Admin.restore');
            Route::delete('/{id}', 'AdminController@destroy')->name('Admin.destroy');
        });
        Route::group(['prefix' => '/industries'], function () {
            Route::post('/', 'IndustryController@store')->name('Industry.store');
            Route::get('/', 'IndustryController@index')->name('Industry.index');
            Route::delete('/{id}', 'IndustryController@destroy')->name('Industry.destroy');
            Route::patch('/{id}', 'IndustryController@update')->name('Industry.update');
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
