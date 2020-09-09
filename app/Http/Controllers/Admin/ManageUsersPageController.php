<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\User\UserSearchRequest;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageUsersPageController extends Controller
{
    public $paginate = 6;

    public function index()
    {
        $users = User::orderBy("id", "asc")->simplePaginate($this->paginate);//ID順
        return view("admin.manage_users", ["users"=>$users]);
    }

    public function search(UserSearchRequest $request)
    {
        //検索文字列でカラム検索
        $search_text = $request->search_text;
        $users = User::searchText($search_text);

        return  view("admin.manage_users", ["users"=>$users]);
    }

    public function getUserSummary()
    {
        //日付を用意
        $start = Carbon::today()->subMonth(6);//本日より一年前(subyear)の日付を格納
        $end = Carbon::today();//本日の日付を格納

        $summary = User::summary($start,$end)->get();


        $d = $start->copy();
        //日付が本日まで(less than equal)の分処理をする
        $count = 0;
        while ($d->lte($end)) {
            //用意された1日刻みの日付に対して該当の作成日のユーザがある場合、$dataに$summaryのオブジェクトを格納
            $data = $summary->first(function ($user) use ($d) {//firstメソッド内foreachがコレクション$summaryからオブジェクト$diaryを一件ずつ取得し、functionを実行
                return $user->date == $d->format('Y-m-d');//日記の日付と用意された1日刻みの日付を比較
            });
            $count += optional($data)->users ?? 0;
            $result[] = ['date' => $d->format('Y-m-d'), 'userCount' => $count];
            $d->addDay();//日付を進める
        }

        return response()->json($result);
    }
}
