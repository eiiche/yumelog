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


Auth::routes();

Route::get('yumelog', 'YumeLogController@index');

//write
Route::get('yumelog/writelog', function (){return view("yumelog.writelog");});




//アドレス yumelog にpostアクセス(フォーム送信)された場合のルーティング
Route::post("yumelog","DiaryController@store");

Route::get("yumelogPost","YumelogController@index");

Route::get("logout","YumelogController@logout");

Route::post("yumelog/postFav","FavoriteController@postFavorite");

Route::group(['middleware' => ['auth.withInstance']], function () {
    Route::get('yumelog/mypage',"MypageController@index");

    Route::get('yumelog/favorite', "YumelogController@favorite");

});
