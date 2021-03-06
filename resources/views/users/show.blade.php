@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <section class="user_info">
      @include('shared._user_info', ['user' => $user])
    </section>

    @if (Auth::check())
    {{--有登入才渲染追蹤--}}
      @include('users._follow_form')
    @endif

    <section class="stats mt-2">
      @include('shared._stats', ['user' => $user])
    </section>
    <section class="status">
      {{--使用count()判斷是否有動態--}}
      @if (count($statuses) > 0)
        <ul class="list-unstyled">
          @foreach ($statuses as $status)
            @include('statuses._status')
          @endforeach
        </ul>
        <div class="mt-5">
          {!! $statuses->render() !!}
        </div>
      @else
      <p>沒有資料</p>
      @endif
        </section>

      </div>
    </div>
@stop
