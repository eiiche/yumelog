<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YumeLogController extends Controller
{
    //web.phpからgetアクセスされた際の処理を記述
    //ログイン状態確認のため、Requestを引数に受け取り、判定
    public function  index(Request $request){

        //ログイン確認
        $user = Auth::user();//ログインしているユーザのモデルインスタンスを返す。ログインしていなければnull
        $param = ["user" => $user];//パラメータに格納
            return view ("yumelog.index",$param);
    }
}
