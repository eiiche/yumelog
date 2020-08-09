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
    //
    private $perPage = 30;

    //web.phpからgetアクセスされた際の処理を記述
    //ログイン状態確認のため、Requestを引数に受け取り、判定
    public function index(Request $request)
    {

        //ログイン確認
        $user = Auth::user();//ログインしているユーザのモデルインスタンスを返す。ログインしていなければnull

        //TOP一覧表示用の日記を取得
        //TODO:一覧取得はDiaryControllerに移行した方が良さそう
        //最新の投稿を30件数一覧取得
        $diaries = Diary::latest()->paginate();

        //$user=trueの場合(ログイン済)、ユーザのお気に入りデータを取得。$userがfalseなら空を挿入
        //A ? B : C
        $faves = $user ?
                Favorite::where("user_id", "=", $user->id)->whereIn('diary_id', $diaries->pluck('id'))->pluck('diary_id')
                :
                collect([])
        ;

        return view("yumelog.index", ["user" => $user,"diaries" => $diaries,"faves" => $faves]);
    }

    public function mypage()
    {
        $user = Auth::user();//ログインしているユーザ取得

        $diaries = Diary::where("author_id", "=", $user->id)->get();

        return view("yumelog.mypage", ["diaries" => $diaries]);
    }


    public function favorite()
    {
        $user = Auth::user();//ログインしているユーザ取得
        $diaries = $user
            ? Diary::whereHas('favorites', function ($query) use ($user) {//リレーション先が存在するか
                $query->where('user_id', $user->id);
            })->get()
            : collect([])
        ;
        return view("yumelog.favorite", ["user" => $user,"diaries" => $diaries]);
    }


    //ログアウト
    public function logout()
    {
        Auth::logout();

        return redirect("yumelog");
    }
}
