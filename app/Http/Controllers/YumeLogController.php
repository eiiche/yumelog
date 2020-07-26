<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YumeLogController extends Controller
{
    //web.phpからgetアクセスされた際の処理を記述
    //ログイン状態確認のため、Requestを引数に受け取り、判定
    public function  index(Request $request){
        $user = Auth::user();

    }
}
