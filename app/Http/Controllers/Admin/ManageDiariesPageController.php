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
        $author_id = $request->author_id;
        $since_date = $request->since_date;
        $until_date = date('Y-m-d H:i:s', strtotime($request->until_date . ' +1 day'));//一日加算し当日の0時まで検索可能にする
        //検索
        $diaries =
            Diary::when($search_text, function($query, $search_text) {//search_textがtrueの場合search_textで検索

            $query->searchText($search_text);
            })
            ->when($author_id, function($query, $author_id) {//author_idがtrueの場合author_idで検索
                $query->authorId($author_id);
            })
            ->where(function($query) use($since_date, $until_date) {
                if ($since_date && $until_date) {
                    $query->date($since_date,$until_date);
                }
            })
            ->get();

        //ビューに渡す
        return view("admin.manage_diaries",["diaries"=>$diaries]);
    }

    public function  chartDiaries(){
        $diaries = Diary::latest()->get();//投稿を全件取得。created_at昇順
        $result = "";
        foreach($diaries as $diary){//日付ごとの件数集計
//
        }

        return response()->json($result);
    }
}
