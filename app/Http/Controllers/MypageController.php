<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{

    /**
     * 投稿した日記一覧画面を表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //著者とログインユーザに紐づく日記を取得。(ユーザidはAuthWithInstanceミドルウェアから受け取る)
        $user = Auth::user();//ログインしているユーザ取得

        $diaries = Diary::where("author_id", "=", $user->id)->get();

        return view("yumelog.mypage", ["diaries" => $diaries]);
    }
}
