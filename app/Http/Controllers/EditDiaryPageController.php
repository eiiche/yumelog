<?php

namespace App\Http\Controllers;
use App\Diary;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditDiaryPageController extends Controller
{
    public function index(Request $request){

        //mypageのeditbtn押下にて、パラメータを追加しeditDiaryビューに遷移
        $diary_id = $request->editbtn;//mypageのeditbtnから日記id取得
        $diary = Diary::find($diary_id);
        return view("yumelog.editDiary",["diary" => $diary]);
    }
}
