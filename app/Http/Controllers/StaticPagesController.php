<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    public function home(){
        //定義一個空數組來存放貼文動態數據
        $feed_items = [];
        //確認用戶已登入
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(15);
        }
        return view('static_pages/home', compact('feed_items'));
    }

    public function help(){
        return view('static_pages/help');
    }

    public function about(){
        return view('static_pages/about');
    }
}
