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

/** 회원가입 */
Route::post('/register', 'AuthController@register');
/** 로그인 */
Route::post('/login', 'AuthController@login');
/*
passport를 사용하기 위해서는 인증이 필요하다.
따라서, Route에 Middleware를 달아서 인증을 거치고 들어가게 설정하자!!

auth: 뒤에 오는 값은 config/auth.php에서 설정 가능하다.
*/
/** 로그아웃 */
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

/** 유저 정보 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
