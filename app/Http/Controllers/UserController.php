<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(){
        return view('users.create');
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function store(Request $request){
    $this->validate($request, [
        'name' => 'required|unique:users|max:50',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|confirmed|min:6'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    session()->flash('success', '歡迎您的註冊');

    return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request){
        //先驗證
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => ['required', Rule::unique('users')->ignore($user), 'max:50'],
            'password' => 'nullable|confirmed|min:6'
        ]);

        //再更新
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '資料更新成功');
        return redirect()->route('users.show', $user->id);
    }

    public function __construct(){
        //未登入用戶將導向登錄頁面，防止未登入修改資料
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index']
        ]);

    }

    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
