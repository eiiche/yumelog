<?php

namespace App\Http\Controllers\Admin;

use App\Diary;
use App\Http\Controllers\Controller;
use App\Http\Requests\Diary\DiarySearchRequest;
use Illuminate\Http\Request;

class ManageDiariesPageController extends Controller
{
    //管理画面 Diaryテーブル一覧表示
    public function index(){
        $diaries = Diary::latest()->get();
        return view("admin.manage_diaries",["diaries"=>$diaries]);
    }

    //管理画面　Diaryテーブル検索処理
    public function search(DiarySearchRequest $request){
        //検索値を用意
        $search_text = $request->search_text;
        $search_id = $request->id;
        $since_date = $request->since_date;
        $until_date = $request->until_date;
        //検索
        $diaries =
            Diary::
                //日記ID・投稿文検索
            where("id","like","%".$search_text."%")
            ->orWhere("text","like","%".$search_text."%")
                //投稿者ID検索
            ->where("author_id","=",$search_id)
                //登校日検索
            ->whereBetween("created_at",[$since_date,$until_date])->get();

        //ビューに渡す
        return view("admin.manage_diaries",["diaries"=>$diaries]);
    }
}
