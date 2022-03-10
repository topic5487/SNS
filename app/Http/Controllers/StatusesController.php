<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $request){
        //先驗證發文內容
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        //獲取當前用戶 並對發文內容賦值
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        return redirect()->back();

    }

    public function destroy(Status $status){
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '刪除成功');
        return redirect()->back();
    }
}
