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
            if(Auth::user()->activated) {
            //登入成功後操作
            session()->flash('success', 'Welcome Back!');
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
        } else {
            //帳號未開通提示
            Auth::logout();
            session()->flash('warning', '帳號未開通，請檢查信箱中的註冊信件進行開通');
            return redirect('/');
        }
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
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
        //只讓未登入用戶訪問註冊頁面
        $this->middleware('guest', [
            'only' => ['create']
            ]);

        //登入頻率限制
        $this->middleware('throttle:10,10', [
            'only' => ['store']
        ]);
    }

}
