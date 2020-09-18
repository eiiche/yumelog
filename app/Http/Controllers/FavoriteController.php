<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    /**
     * お気に入り登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFavorite(Request $request)
    {
        //テーブル編集用のデータを生成
        $diary_id = $request->favoritebtn;//ビューのフォームからidを取得
        $user_id = Auth::user()->id;//ログインしているuseridを取得

        //紐づくお気に入りレコードを取得。ない場合はnullが格納される
        //紐づいたFavoriteモデルのオブジェクトを取得。
        //scopeはquerybuilderを返すので、オブジェクト取得のfirstメソッドはscope外に記述する
        $favorite = Favorite::idMatch($diary_id, $user_id)->first();
        if ($favorite) {
            //削除処理
            $favorite->delete();
        } else {
            //保存処理
            Favorite::create(['diary_id' => $diary_id, 'user_id' => $user_id]);
        }
        return redirect()->back();
    }
}
