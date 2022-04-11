@if ($statuses->count() > 0)
  <ul class="list-unstyled">
    @foreach($statuses as $status)
      @include('statuses._status',  ['user' => $status->user])
    @endforeach
  </ul>
@else
  <p>查無資料</p>
@endif

