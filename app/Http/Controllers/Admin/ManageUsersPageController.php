<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageUsersPageController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        return view("admin.manage_users",["users"=>$users]);
    }

    public function search(Request $request){
        //検索文字列でカラム検索
        $search_text = $request->search_text;
        $users = User::where("id","like","%".$search_text."%")
            ->orWhere("name","like","%".$search_text."%")
            ->orWhere("email","like","%".$search_text."%")->get();

        return  view("admin.manage_users",["users"=>$users]);
    }
}
