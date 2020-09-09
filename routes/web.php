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


//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('yumelog', 'YumeLogController@index')->name('yumelog');



//アドレス yumelog にpostアクセス(フォーム送信)された場合のルーティング
Route::post("yumelog", "DiaryController@store")->name('wroteDiary');

Route::get("yumelogPost", "YumelogController@index");

Route::get("yumelogAbout", function () {
    return view("yumelog.about");
})->name("about");

Route::get("logout", "Auth\LoginController@logout");

Route::post("yumelog/editedDiary", "DiaryController@update")->name('editedDiary');

Route::post("yumelog/postFav", "FavoriteController@postFavorite")->name('postFav');

Route::post("yumelog/editDiary", "EditDiaryPageController@index")->name('editDiarySession');
Route::get('yumelog/editDiary',"EditDiaryPageController@show")->name('editDiary');

Route::post("yumelog/deleteDiary", "DiaryController@destroy")->name('deleteDiary');

Route::post("yumelog/deletedDiary", "DiaryController@destroy")->name('deletedDiary');

//ログイン判定をしたいアクセスをグループにし、ミドルウェアを割り当て
Route::group(['middleware' => ['auth']], function () {
    Route::get('yumelog/mypage', "MypageController@index")->name('mypage');
    Route::get('yumelog/favorite', "FavoritePageController@index");
    Route::get('yumelog/writelog', function () {
        return view("yumelog.writelog");
    });
});

//Adminログイン用ルーティング
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Auth::routes(['register' => false]);// /admin/registerのルーティングを登録させない

    Route::get('/home', 'AdminHomeController@index')->name('admin_home');
    Route::get('/manage_users', 'ManageUsersPageController@index')->name('admin_manage_users');
    Route::get('/manage_diaries', 'ManageDiariesPageController@index')->name('admin_manage_diaries');
    Route::get("/manage_favorites", "ManageFavoritesPageController@index")->name("admin_manage_favorites");
    Route::get("/manage_admins", "ManageAdminsPageController@index")->name("admin_manage_admins");
    Route::get("/manage_access_logs", "ManageAccessLogsPageController@index")->name("admin_manage_access_logs");
    Route::get("/manage_admin_logs", "ManageAdminLogsController@index")->name("admin_manage_admin_logs");
    Route::post('/manage_users', 'ManageUsersPageController@search')->name('manage_users');
    Route::post('/manage_diaries', 'ManageDiariesPageController@search')->name('manage_diaries');
    Route::get('/getDiarySummary', 'ManageDiariesPageController@getDiarySummary');//chart.jsによるアクセス
    Route::get('/getUserSummary', 'ManageUsersPageController@getUserSummary');//chart.jsによるアクセス
    Route::post('/sendMail',"MailingController@information")->name('sendMail');
    Route::post("/diary_multiple_delete", "DiaryController@destroy")->name('diary_multiple_delete');
});

Route::post("admin/user_checkbox", "UserController@check")->name('user_checkbox');

Route::post("admin/CSVImport", "CSVController@import_csv")->name("import_csv");
Route::post("admin/CSVExport", "CSVController@export_csv")->name("export_csv");
