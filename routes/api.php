<?php

use Illuminate\Http\Request;

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

Route::get('/blog/list', 'BlogController@getAllBlog')->middleware('api');
Route::post('/blog/delete', 'BlogController@destroy')->middleware('api');
Route::get('/country/list', 'CountryController@index')->middleware('api');
Route::get('/country/city/{id}', 'CityController@index')->middleware('api');
Route::get('/country/state/{id}', 'StateController@index')->middleware('api');
Route::get('/country/area/{id}', 'AreaController@index')->middleware('api');
Route::get('/category/list', 'CategoryController@index')->middleware('api');
Route::post('/category/delete', 'CategoryController@destroy')->middleware('api');

Route::get('/country/list/all', 'CountryController@getCountryData')->middleware('api');
Route::post('/country/delete', 'CountryController@destroy')->middleware('api');
