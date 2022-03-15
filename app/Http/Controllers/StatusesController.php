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

    public function edit($id){
        $status_id = Auth::user()->statuses()->find($id);
        return view('statuses.edit', ['status' => $status_id]);
    }

    public function update(Request $request, $id){
        $status_id = Auth::user()->statuses()->find($id);
        //驗證更新文章內容
        $content = $request -> validate([
            'content' => 'required|max:140'
        ]);

        $status_id->update($content);
        session()->flash('success', '編輯成功');
        return redirect()->route('home');
    }
}
