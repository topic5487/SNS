<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request){
        //驗證信箱
        $request -> validate(['email' => 'required|email']);
        $email = $request->email;

        //取得對應用戶
        $user = User::where("email", $email)->first();

        //如果不存在
        if (is_null($user)) {
            session()->flash('danger', '信箱錯誤');
            return redirect()->back()->withInput();
        }

        //製造token
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        //入database，用updateOrInsert 保持Email 唯一
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);

        //將Token 網址寄給用戶
        Mail::send('emails.reset_link', compact('token'), function ($message) use ($email) {
            $message->to($email)->subject("忘記密碼");
        });
        session()->flash('success', '重置密碼信件已寄出');
        return redirect()->back();
    }
}
