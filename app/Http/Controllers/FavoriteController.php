<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postFavorite(Request $request)
    {
        //テーブル編集用のデータを生成
        $diary_id = $request->favoritebtn;//ビューのフォームからidを取得
        $user_id = Auth::user()->id;//ログインしているuseridを取得

        //紐づくお気に入りレコードを取得。ない場合はnullが格納される
        $favorite = Favorite::where(['diary_id' => $diary_id, 'user_id' => $user_id])->first();//紐づいたFavoriteモデルのオブジェクトを取得
        if ($favorite) {
            //削除処理
            $favorite->delete();
        } else {
            //保存処理
            Favorite::create(['diary_id' => $diary_id, 'user_id' => $user_id]);
        }
        return redirect("/yumelog");
    }
}
