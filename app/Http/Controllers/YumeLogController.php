<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Favorite;
use App\Like;
use App\User;
//use http\Client\Curl\User;
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

        //ログインしている場合、ユーザがお気に入りした日記を取得
        if($user != null) {
            $faves = Favorite::where("favUser", "=", $user->id)->get();
        }
        return view("yumelog.index",["user" => $user,"diaries" => $diaries,"faves" => $faves]);
    }

    public function mypage(){
        $user = Auth::user();//ログインしているユーザ取得

        $diaries = Diary::where("authorId","=",$user->id)->get();

        return view("yumelog.mypage",["diaries" => $diaries]);
    }

    public function favorite(){
        $user = Auth::user();//ログインしているユーザ取得

        //ログインしている場合、ユーザに紐づくお気に入りを取得
        if($user != null) {
            $faves = Favorite::where("favUser", "=", $user->id)->get(   );
        }

        //お気に入りに紐づく日記を取得
        $diaries = Diary::where("id","=",$faves)->get();
        return view("yumelog.favorite",["user" => $user,"diaries" => $diaries]);
    }

    //ログアウト
    public function logout(){
        Auth::logout();

        return redirect("yumelog");
    }
}
