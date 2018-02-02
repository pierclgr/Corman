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

Route::resource('publications', 'PublicationController');

Route::patch('publications/{id}', 'PublicationController@update');

Route::get('/home/import', 'PublicationController@import');

Route::resource('users', 'UserController');

Route::patch('users/{id}', 'UserController@update');

Route::get('/home/user', 'UserController@index');

Route::get('/home/search', 'SearchController@index');

Route::get('/home/search/people','SearchController@searchPeople');

Route::get('/home/search/groups','SearchController@searchGroups');

Route::get('/home/user/filter','UserController@filter');

Route::resource('groups', 'GroupController');

Route::get('groups/{idGroup}', 'GroupController@show');

Route::get('groups/{idGroup}/{idPublication}', 'GroupController@aggiungi')->name('groups.aggiungi');

Route::get('groups/{idGroup}/{idUser}', 'GroupController@rintraccia')->name('groups.rintraccia');