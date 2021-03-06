<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritePageController extends Controller
{

    /**
     * お気に入りした投稿一覧画面を表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();//ログインしているユーザ取得
        $diaries = $user
            ? Diary::whereHas('favorites', function ($query) use ($user) {//リレーション先が存在するか
                $query->where('user_id', $user->id);
            })->get()
            : collect([])
        ;

        $faves = $user ?
            Favorite::where("user_id", "=", $user->id)->whereIn('diary_id', $diaries->pluck('id'))->pluck('diary_id')
            :
            collect([])
        ;
        return view("yumelog.favorite", ["user" => $user,"diaries" => $diaries,"faves"=>$faves]);
    }
}
