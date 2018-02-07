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
    return view('index');
});
// Blog page route
Route::get('/blog', 'BlogController@index')->name('blog.list');
Route::post('/blog/store', 'BlogController@store')->name('blog.store');
// category page route
Route::get('/category', 'CategoryController@index')->name('category.list');
Route::post('/category/store', 'CategoryController@store')->name('category.store');
// Country page route
Route::get('/country', 'CountryController@index')->name('country.list');
Route::post('/country/store', 'CountryController@store')->name('country.store');
