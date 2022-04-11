@extends('layouts.default')
@section('title', $title)

@section('content')
<div class="card-body">
  <section class="status_form">
    @include('shared._status_search')
  </section>
  {{ $statuses->withQueryString()->links() }}
</div>
@endsection
