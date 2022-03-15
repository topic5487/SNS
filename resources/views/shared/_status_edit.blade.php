<form method="POST" action="{{ route('statuses.update', $status)}}">
  {{ method_field('PATCH') }}
  {{ csrf_field()}}

  <textarea class="form-control" rows="3" name="content">{{ $status->content }}</textarea>
  <button type="submit" class="btn btn-primary mt-3">送出</button>

</form>
