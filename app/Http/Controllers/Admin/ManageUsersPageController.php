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
}
