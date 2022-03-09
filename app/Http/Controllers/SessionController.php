<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create(){
        return view('sessions.create');
    }

    public function store(Request $request){
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            //登入成功後操作
            session()->flash('success', 'Welcome Back!');
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
        } else {
            //登入失敗後操作
            session()->flash('danger', '信箱或密碼錯誤');
            return redirect()->back()->withInput();
        }
    }
    public function destroy(){
        Auth::logout();
        session()->flash('success', '已成功登出');
        return redirect('login');
    }

    public function __construct(){
        //只讓未登入用戶訪問註冊頁面
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
            ]);
    }

}
