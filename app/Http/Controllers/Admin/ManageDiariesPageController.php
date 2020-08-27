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

    //chart.jsへのグラフデータ受け渡し
    public function  getDiarySummary(){
        //変数を用意
        $start = Carbon::today()->subYear();//本日より一年前(subyear)の日付を格納
        $end = Carbon::today();//本日の日付を格納
        $postCount= collect([]);

        //日付と日付ごとの件数取得
        $summary = Diary::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as posts'))//日付と日付ごとの件数
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $d = $start->copy();
        //日付が本日まで(less than equal)の分処理をする
        while($d->lte($end)) {
            //用意された1日刻みの日付に対して該当の日付の日記がある場合、$dataに$summaryのオブジェクトを格納
            $data = $summary->first(function ($diary) use ($d) {
                return $diary->date == $d->format('Y-m-d');//日記の日付と用意された1日刻みの日付を比較
            });
            $postCount->push(optional($data)->posts ?? 0);//$dataがnullである場合は0,nullでない場合はpostsを格納
            $d->addDay();//日付を進める
        }


        return response()->json($postCount);
    }
}
