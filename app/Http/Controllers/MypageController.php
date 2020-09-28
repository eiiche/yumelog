<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        $file = $request->file('user_image');
        $name = $file->getClientOriginalName();
        $storePath = "images/".$name;

        $image = Image::make($file)->resize(200, 200)->encode('jpg');//リサイズ

        //s3に保存
        Storage::disk('s3')->put($storePath,(string)$image->encode(), 'public');//第三引数にpublic指定することでURLアクセスを可能にする
        $path = Storage::disk("s3")->url($storePath);

        //ユーザに紐づけ保存
        $user = Auth::user();
        $user->image = $path;

        $user->save();

        return redirect(route('mypage'));
    }
}
