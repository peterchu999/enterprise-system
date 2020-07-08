<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/companies'], function () {
    Route::get('/', 'CompanyController@index')->name('Company.api.index');
    Route::post('/', 'CompanyController@store')->name('Company.api.store');
    Route::get('/{id}', 'CompanyController@show')->name('Company.api.show');
    Route::patch('/{id}', 'CompanyController@update')->name('Company.api.update');
    Route::delete('/{id}', 'CompanyController@destroy')->name('Company.api.destroy');
});

Route::group(['prefix' => '/contacts'], function () {
    Route::get('/', 'ContactPersonController@index')->name('ContactPerson.api.index');
    Route::post('/', 'ContactPersonController@store')->name('ContactPerson.api.store');
    Route::get('/{id}', 'ContactPersonController@show')->name('ContactPerson.api.show');
    Route::patch('/{id}', 'ContactPersonController@update')->name('ContactPerson.api.update');
    Route::delete('/{id}', 'ContactPersonController@destroy')->name('ContactPerson.api.destroy');
});



