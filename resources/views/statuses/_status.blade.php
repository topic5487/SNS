<li class="d-flex mt-4 mb-4">
  <a class="flex-shrink-0" href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="me-1 gravatar"/>
  </a>
  <div class="flex-grow-1 ms-3">
  <h5 class="mt-0 mb-1">{{ $user->name }} <small> / {{ $status->created_at->diffForHumans()/*diffForHumans使時間格式更人性化*/ }}</small></h5>
    {{ $status->content }}
  </div>

  {{--刪除文章按鈕--}}
  @can('destroy', $status)
    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" onsubmit="return confirm('確定刪除嗎?');">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger status-delete-btn">刪除</button>
    </form>

  @endcan

  @can('edit', $status)
  <form><a class="btn btn-sm btn-danger status-delete-btn" href="{{ route('statuses.edit', $status->id) }}">編輯</a></form>
  @endcan
</li>
