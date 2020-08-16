<?php

namespace App\Http\Controllers\Admin;

use App\Diary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageDiariesPageController extends Controller
{
    public function index(){
        $diaries = Diary::latest()->get();
        return view("admin.manage_diaries",["diaries"=>$diaries]);
    }
}
