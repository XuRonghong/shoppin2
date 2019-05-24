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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('news/list', 'NewsController@list')->name('news.list');
Route::resource('news', 'NewsController');


Route::resource('product', 'ProductController');


Route::get('group', 'GroupController@index')->name('group.index');
Route::get('group/list', 'GroupController@list')->name('group.list');
Route::post('group', 'GroupController@store')->name('group.store');
Route::get('group/edit', 'GroupController@edit')->name('group.edit');
Route::get('group/destroy', 'GroupController@destroy')->name('group.destroy');
Route::delete('group/mass_destroy', 'GroupController@massDestroy')->name('group.mass_destroy');