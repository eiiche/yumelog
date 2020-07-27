<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YumeLogController extends Controller
{
    //web.phpからgetアクセスされた際の処理を記述
    //ログイン状態確認のため、Requestを引数に受け取り、判定
    public function  index(Request $request){
        //ログインしているユーザのモデルインスタンスを返す。もしくはnull
        $user = Auth::user();
        $param = ["user" => $user];
            return view ("layouts.homeLayout",$param);
    }
    public function post(Request $request){
        $content = $request->input("content");
        return view();
    }
}
