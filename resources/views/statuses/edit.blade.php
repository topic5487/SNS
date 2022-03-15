@extends('layouts.default')
@section('title', '編輯文章')

@section('content')
<div class="card-body">
  @include('shared._errors')
  <section class="status_form">
    @include('shared._status_edit')
  </section>
</div>
@stop
