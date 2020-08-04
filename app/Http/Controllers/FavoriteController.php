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

    public function postFavorite(Request $request){
        //テーブル編集用のキーを生成
        $diary_id = $request->favoritebtn;
        $user_id = Auth::user()->id;//userId用にログインユーザインスタンス取得

        $favorite = new Favorite();//格納用インスタンス生成
        $favorite->user_id = $user_id;
        $favorite->diary_id = $diary_id;
        $result = Favorite::where("diary_id","=",$diary_id)->where("user_id","=",$user_id)->get();
        //フォームからdairyIdを受け取り、該当のお気にいりレコードの有無に応じてテーブルを挿入・削除
        if(isset($result) == false){
            //保存処理
            $favorite->save();
        }else{
            //削除処理
            $favorite->delete();
        }

        return redirect("/yumelog");

    }
}
