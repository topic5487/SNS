@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <section class="user_info">
      @include('shared._user_info', ['user' => $user])
    </section>
    <section class="status">
      {{--使用count()判斷是否有動態--}}
      @if ($statuses->count() > 0)
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
