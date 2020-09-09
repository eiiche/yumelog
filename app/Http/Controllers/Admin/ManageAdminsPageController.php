<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageAdminsPageController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();
        return view("admin.manage_admin", ["admins"=>$admins]);
    }
}
