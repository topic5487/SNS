@can('follow', $user)
  <div class="text-center mt-2 mb-4">
    {{--透過用戶模型中的isFollowing方法判斷應顯示追蹤還是取消--}}
    @if (Auth::user()->isFollowing($user->id))
      <form action="{{ route('followers.destroy', $user->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-outline-primary">取消追蹤</button>
      </form>
    @else
      <form action="{{ route('followers.store', $user->id) }}" method="post">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-sm btn-primary">追蹤</button>
      </form>
    @endif
  </div>
@endcan
