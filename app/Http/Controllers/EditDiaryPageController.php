<?php

namespace App\Http\Controllers;

use App\Diary;

use App\Http\Requests\Diary\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditDiaryPageController extends Controller
{
    public function index(Request $request)
    {

        $diary_id = $request->editbtn;//mypageの編集ボタンからdiary_id取得
        $diary = Diary::find($diary_id)->first();//該当の投稿を取得
        $request->session()->put("diary_session",$diary);//セッションに保存

        return redirect(route('editDiary'));
    }

    public  function show(Request $request){

        $session = $request->session()->get("diary_session");
        return view("yumelog.editDiary",['diary_session' => $session]);
    }
}
