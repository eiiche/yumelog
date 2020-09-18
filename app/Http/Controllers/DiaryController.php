<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Requests\Diary\StoreRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        Diary::create($request->validated());
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreRequest $request)
    {
        $diary_id = $request->diary_id;//日記のid取得
        $diary_text = $request->text;//日記の編集後テキスト取得
        Diary::where("id", $diary_id)->update(["text"=>$diary_text]);

        return redirect(route('mypage'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        //リクエストから送信ユーザと投稿IDを取得
        $admin = Auth::guard('admin')->check();
        $user =  $request->user();
        $diary_id = $request->diary_id;
        //ログインユーザが管理者でない場合、ID比較、削除判定
        if ($user != null) {
            if ($user->can('isUser', $diary_id)) {
                Diary::destroy($request->diary_id);
            }
        }

        Diary::destroy($request->diary_id);

        return redirect()->back();
    }
}
