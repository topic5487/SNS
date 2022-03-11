<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(){
        return view('users.create');
    }

    public function show(User $user){
        $statuses = $user->statuses()
        //對文章進行排序
        ->orderBy('created_at', 'desc')
        //每頁顯示十則
        ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
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

    $this->sendEmailConfirmationTo($user);
    session()->flash('success', '驗證信件已寄至註冊郵箱，請前往開通');
    return redirect('/');
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
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index','confirmEmail']
        ]);

        //限制註冊請求頻率
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);

    }

    public function index(){
        //分頁，一頁顯示六筆用戶
        $users = User::paginate(6);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '刪除用戶成功');
        return back();
    }

    protected function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感謝註冊！請確認您的信箱";
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token){
        $user = User::where('activation_token', $token)->firstOrFail();//firstOrFail取出第一個用戶
        //查到用戶後，把此用戶開通狀態改為true，activation_token設為空
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        //最後進行登入、提示、跳轉頁面
        Auth::login($user);
        session()->flash('success', '開通成功');
        return redirect()->route('users.show', [$user]);
    }

    public function followings(User $user){
        $users = $user->followings()->paginate(30);
        $title = $user->name . '追蹤中';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers(User $user){
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉絲';
        return view('users.show_follow', compact('users', 'title'));
    }

}
