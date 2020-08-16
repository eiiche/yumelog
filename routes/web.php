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

Route::get("logout","Auth\LoginController@logout");

Route::post("yumelog/editedDiary","DiaryController@update");

Route::post("yumelog/postFav","FavoriteController@postFavorite");

Route::post("yumelog/editDiary","EditDiaryPageController@index");

Route::post("yumelog/deleteDiary","DeleteDiaryPageController@index");

Route::post("yumelog/deletedDiary","DiaryController@destroy");

//ログイン判定をしたいアクセスをグループにし、ミドルウェアを割り当て
Route::group(['middleware' => ['auth']], function () {
    Route::get('yumelog/mypage',"MypageController@index");
    Route::get('yumelog/favorite', "FavoritePageController@index");
});

//Adminログイン用ルーティング
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function(){

    Auth::routes(['register' => false]);// /admin/registerのルーティングを登録させない

    Route::get('/home', 'AdminHomeController@index')->name('admin_home');
    Route::get('/manage_users', 'ManageUsersPageController@index')->name('admin_manage_users');
    Route::get('/manage_diaries', 'ManageDiariesPageController@index')->name('admin_manage_diaries');
    Route::get("/manage_favorites","ManageFavoritesPageController@index")->name("admin_manage_favorites");
    Route::get("/manage_admins","ManageAdminsPageController@index")->name("admin_manage_admins");
    Route::get("/manage_access_logs","ManageAccessLogsPageController@index")->name("admin_manage_access_logs");
    Route::get("/manage_admin_logs","ManageAdminLogsController@index")->name("admin_manage_admin_logs");
});
