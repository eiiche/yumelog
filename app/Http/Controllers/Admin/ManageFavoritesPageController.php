<?php

namespace App\Http\Controllers\Admin;

use App\Favorite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageFavoritesPageController extends Controller
{
    public function index()
    {
        $favorites = Favorite::latest()->get();
        return view("admin.manage_favorites", ["favorites"=>$favorites]);
    }
}
