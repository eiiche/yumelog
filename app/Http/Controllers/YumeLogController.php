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

}
