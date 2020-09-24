<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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

    public function iconUpload(ImageUploadRequest $request)
    {
        //リサイズ後　publicフォルダに画像保存
        $file = $request->file('user_image');
        $extension = $file->getClientOriginalExtension();//拡張子取得
        $filename = $file->getClientOriginalName();//ファイル名取得
        $filepath = pathinfo($filename, PATHINFO_FILENAME);//ファイルパス生成
        $fileNameToStore = $filepath . "." . $extension;//ファイルパス+ファイル名+拡張子(user保存用)
        Image::make($file)->resize(200, 200)->save(public_path('storage/' . $filename));


        //ユーザに紐づけ保存
        $user = Auth::user();
        $user->image = $fileNameToStore;

        $user->save();

        return redirect(route('mypage'));
    }
}
