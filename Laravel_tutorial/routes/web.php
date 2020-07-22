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
/*
    [ How to Set Laravel Middleware Setting ]
    (1) 1 : 1 Route Middleware Setting
 */
Route::get('/tasks', 'TaskController@index')->middleware('auth');
/*
    (2) 1 : n Route Middleware Setting

    1. prefix를 선언하여 url에 공용 주소 셋팅.
    2. prefix로 선언 된 Route에 공용 Middleware Setting => group으로 묶어주기.
*/
Route::prefix('tasks')->middleware('auth')->group(function () {

    Route::get('/create', 'TaskController@create')->middleware('auth');;

    Route::post('/', 'TaskController@store');

    Route::get('/{task}', 'TaskController@show');

    Route::get('/{task}/edit', 'TaskController@edit');

    Route::put('/{task}', 'TaskController@update');

    Route::delete('/{task}', 'TaskController@destroy');
});

/*
    라라벨에서 선호하는 CRUD Route페이지 자동으로 생성
    Route::resource('tasks', 'TaskController')->middleware('auth');
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
