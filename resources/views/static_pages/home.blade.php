@extends('layouts.default')

@section('content')
  @if (Auth::check())
  {{--已登入者 即顯示表單--}}
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')
        </section>
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
  @else
    <div class="bg-light p-3 p-sm-5 rounded">
      <h1>主頁</h1>
      <p class="lead">
        你現在看到的是 <a href="https://learnku.com/courses/laravel-essential-training"></a>。
      </p>
      <p>
        一切，將從這裡開始。
      </p>
      <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">現在註冊</a>
      </p>
    </div>
  @endif
@stop
