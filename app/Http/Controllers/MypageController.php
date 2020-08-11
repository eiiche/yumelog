<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        //著者とログインユーザに紐づく日記を取得。(ユーザidはAuthWithInstanceミドルウェアから受け取る)
        $user = Auth::user();//ログインしているユーザ取得

        $diaries = Diary::where("author_id", "=", $user->id)->get();

        return view("yumelog.mypage", ["diaries" => $diaries]);
    }
}
