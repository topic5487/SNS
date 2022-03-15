@extends('layouts.default')

@section('content')
  @if (Auth::check())
  {{--已登入者 即顯示表單--}}
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')
        </section>
        <h4>文章列表</h4>
        <hr>
        @include('shared._feed')
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user' => Auth::user()])
        </section>
        <section class="stats mt-2">
          @include('shared._stats', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
  @else
    <div class="bg-light p-3 p-sm-5 rounded">
      <h1>註冊後使用SNS</h1>
      <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">現在註冊</a>
      </p>
    </div>
  @endif
@stop
