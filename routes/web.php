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

Route::get('/', 'HomeController@index');

Route::get('/hello', 'HomeController@hello');

Route::get('/contact', 'HomeController@contact');

Route::get('/projects', 'ProjectController@index');

/*
    RESTFUL API [Actions Handled By Resource Controller]
    get로 보낼때 복수형으로 선언, action이 index ( 기본 )
    get로 보낼때 복수형으로 선언, action이 create
    post로 보낼때 복수형으로 선언, action이 store
*/
Route::get('/tasks', 'TaskController@index');

Route::get('/tasks/create', 'TaskController@create');

Route::post('/tasks', 'TaskController@store');

Route::get('/tasks/{task}', 'TaskController@show');
