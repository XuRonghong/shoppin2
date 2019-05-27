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
//    return view('welcome');
    return view('index');
});


Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();



//Route::get('login', 'LoginController@index')->name('login.index');
Route::post('login/checklogin', 'LoginController@checklogin')->name('login.check');
Route::get('login/successlogin', 'LoginController@successlogin')->name('login.success');
Route::get('login/logout', 'LoginController@logout')->name('logout');

//Route::get('/register', 'LoginController@registerView');
Route::post('register/check', 'LoginController@registerCheck')->name('register.check');



Route::get('/live_search', 'AjaxController@live_search');
Route::get('/live_search/action', 'AjaxController@search')->name('live_search.search');





Route::get('news/list', 'NewsController@list')->name('news.list');
Route::resource('news', 'NewsController');


Route::resource('product', 'ProductController');


Route::get('group', 'GroupController@index')->name('group.index');
Route::get('group/list', 'GroupController@list')->name('group.list');
Route::post('group', 'GroupController@store')->name('group.store');
Route::get('group/edit', 'GroupController@edit')->name('group.edit');
Route::delete('group/destroy', 'GroupController@destroy')->name('group.destroy');
Route::delete('group/mass_destroy', 'GroupController@massDestroy')->name('group.mass_destroy');



Route::get('/uploadfile', 'UploadfileController@index');
Route::post('/uploadfile', 'UploadfileController@upload');
Route::post('/uploadfile/action', 'UploadfileController@AjaxUpload')->name('ajaxupload.action');



Route::get('/dynamic_dependent', 'AjaxController@dynamicDependent');
Route::post('dynamic_dependent/fetch', 'AjaxController@dynamicDependentFetch')->name('dynamicdependent.fetch');
Route::post('autocomplete/fetch', 'AjaxController@AutoCompleteFetch')->name('autocomplete.fetch');



Route::get('/export_excel', 'ExportController@index');
Route::get('/export_excel/excel', 'ExportController@excel')->name('export_excel.excel');

Route::get('/dynamic_pdf/pdf', 'ProductController@pdf');



Route::get('member', 'MemberController@index')->name('member.index');




Route::get('/livetable', 'LiveTable@index');
Route::get('/livetable/fetch_data', 'LiveTable@fetch_data')->name('livetable.fetch_data');
Route::post('/livetable/add_data', 'LiveTable@add_data')->name('livetable.add_data');
Route::post('/livetable/update_data', 'LiveTable@update_data')->name('livetable.update_data');
Route::post('/livetable/delete_data', 'LiveTable@delete_data')->name('livetable.delete_data');



Route::get('/loadmore', 'ArticleController@index');
Route::post('/loadmore/load_data', 'ArticleController@load_data')->name('loadmore.load_data');

