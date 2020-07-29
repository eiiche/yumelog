<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YumeLogController extends Controller
{
    //web.phpからgetアクセスされた際の処理を記述
    //ログイン状態確認のため、Requestを引数に受け取り、判定
    public function  index(Request $request){

        //ログイン確認
        $user = Auth::user();//ログインしているユーザのモデルインスタンスを返す。ログインしていなければnull

        //TOP一覧表示用の日記を取得
        //TODO:一覧取得はDiaryControllerに移行した方が良さそう
        //最新の投稿を30件数一覧取得
        $diaries = Diary::latest()->paginate(30);

        return view("yumelog.index",["user" => $user,"diaries" => $diaries]);
    }

    public function mypage(){
        $user = Auth::user();//ログインしているユーザ取得

        //最新からauthorId=全件取得
        $diaries = Diary::with("user")->get();

        return view("yumelog.mypage",["diaries" => $diaries]);
    }
}
