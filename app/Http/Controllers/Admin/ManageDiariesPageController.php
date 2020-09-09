<?php

namespace App\Http\Controllers\Admin;

use App\Diary;
use App\Http\Controllers\Controller;
use App\Http\Requests\Diary\DiarySearchRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageDiariesPageController extends Controller
{
    public $paginate = 6;

    //管理画面 Diaryテーブル一覧表示
    public function index()
    {
        $diaries = Diary::orderBy("id", "asc")->simplePaginate($this->paginate);//ID順
        return view("admin.manage_diaries", ["diaries"=>$diaries]);
    }

    //管理画面　Diaryテーブル検索処理
    public function search(DiarySearchRequest $request)
    {
        //検索値を用意
        $search_text = $request->search_text;
        $author_id = $request->author_id;
        $since_date = $request->since_date;
        $until_date = date('Y-m-d H:i:s', strtotime($request->until_date . ' +1 day'));//一日加算し当日の0時まで検索可能にする

        $diaries = Diary::search($search_text,$author_id,$since_date,$until_date);

        //ビューに渡す
        return view("admin.manage_diaries", ["diaries"=>$diaries]);
    }

    //chart.jsへのグラフデータ受け渡し
    public function getDiarySummary()
    {
        //変数を用意
        $start = Carbon::today()->subMonth(6);//本日より一年前(subyear)の日付を格納
        $end = Carbon::today();//本日の日付を格納

        //日付と日付ごとの件数取得
        $summary = Diary::summary($start,$end)->get();

        //日付を用意
        $d = $start->copy();
        //日付が本日まで(less than equal)の分処理をする
        $count = 0;
        while ($d->lte($end)) {
            //用意された1日刻みの日付に対して該当の日付の日記がある場合、$dataに$summaryのオブジェクトを格納
            $data = $summary->first(function ($diary) use ($d) {//firstメソッド内foreachがコレクション$summaryからオブジェクト$diaryを一件ずつ取得し、functionを実行
                return $diary->date == $d->format('Y-m-d');//日記の日付と用意された1日刻みの日付を比較
            });
            $count += optional($data)->posts ?? 0;
            $result[] = ['date' => $d->format('Y-m-d'), 'postCount' => $count];
            $d->addDay();//日付を進める
        }


        return response()->json($result);
    }
}
