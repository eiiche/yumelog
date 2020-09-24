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


    /**
     * TOP画面表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        //ログイン確認
        $user = Auth::user();//ログインしているユーザのモデルインスタンスを返す。ログインしていなければnull

        //TOP一覧表示用の日記を取得
        //TODO:一覧取得はDiaryControllerに移行した方が良さそう
        $diaries = Diary::latest()->paginate();//diaryクラスのperpageが使用される

        //$user=trueの場合(ログイン済)、ユーザのお気に入りデータを取得。$userがfalseなら空を挿入
        //A ? B : C
        $faves = $user ?
            Favorite::where("user_id", "=", $user->id)->whereIn('diary_id', $diaries->pluck('id'))->pluck('diary_id')
            :
            collect([]);

        return view("yumelog.index", ["user" => $user, "diaries" => $diaries, "faves" => $faves]);
    }

    public function test()
    {
    }
}
