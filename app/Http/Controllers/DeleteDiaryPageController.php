<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;

class DeleteDiaryPageController extends Controller
{
    public function index(Request $request){

        //mypageのdeletebtn押下にて、パラメータを追加しdeleteDiaryビューに遷移
        $diary_id = $request->deletebtn;//mypageのdeletebtnから日記id取得

        return view("yumelog.deleteDiary",["diary_id" => $diary_id]);

    }
}
