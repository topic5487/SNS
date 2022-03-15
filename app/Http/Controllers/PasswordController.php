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
    public function showLinkRequestForm (){
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
            $message->to($email)->subject("請盡速重置您的密碼");
        });
        session()->flash('success', '重置密碼信件已寄出');
        return redirect()->back();
    }

    public function showResetForm(Request $request){
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request){
        //驗證
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $email = $request->email;
        $token = $request->token;
        // 重置密碼網址的有效時間
        $expires = 60 * 10;

        //取得對應的用戶
        $user = User::where("email", $email)->first();

        //如不存在
        if (is_null($user)) {
            session()->flash('danger', '信箱錯誤');
            return redirect()->back()->withInput();
        }

        //讀取重置紀錄
        $record = (array) DB::table('password_resets')->where('email', $email)->first();

        //紀錄存在的話
        if ($record) {
            //先檢查網址是否過期
            if (Carbon::parse($record['created_at'])->addSeconds($expires)->isPast()) {
                session()->flash('danger', '網址已過期');
                return redirect()->back();
            }
            //檢查token是否正確
            if ( ! Hash::check($token, $record['token'])) {
                session()->flash('danger', '錯誤');
                return redirect()->back();
            }
            //如一切正確 更新用戶密碼
            $user->update(['password' => bcrypt($request->password)]);
            session()->flash('success', '密碼重置成功');
            return redirect()->route('login');
        }
        //如紀錄不存在
        session()->flash('danger', '錯誤');
        return redirect()->back();
    }

    public function __construct(){
        //針對重置密碼表單做限制訪問頻率
        $this->middleware('throttle:20,10', [
            'only' => ['showLinkRequestForm']
        ]);

        //針對發送密碼重置信做頻率限制
        $this->middleware('throttle:20,10', [
            'only' => ['sendResetLinkEmail']
        ]);
    }
}
