<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritePageController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();//ログインしているユーザ取得
        $diaries = $user
            ? Diary::whereHas('favorites', function ($query) use ($user) {//リレーション先が存在するか
                $query->where('user_id', $user->id);
            })->get()
            : collect([])
        ;
        return view("yumelog.favorite", ["user" => $user,"diaries" => $diaries]);
    }
}