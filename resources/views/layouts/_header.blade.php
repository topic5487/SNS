<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">SNS</a>
    <ul class="navbar-nav justify-content-end">
      {{--判斷當前用戶是否已登錄--}}
      @if (Auth::check())
      <div class="input-group ">
        <form action="{{ route('status.search') }}" method="GET">
          <input class=" form-control-sm" type="text" name="search" placeholder="Search" required />
          <span>
            <button class="btn btn-outline-secondary btn-sm" type="submit">Search</button>
          </span>
        </form>
      </div>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">個人中心</a>
          <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">編輯資料</a>
            @if(Auth::user()->is_admin == 1)
              <a class="dropdown-item" href="{{ route('users.index') }}">用户列表</a>
            @endif
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" id="logout" href="#" >
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('確定要登出嗎?');">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="btn btn-block btn-danger" type="submit" name="button">登出</button>
            </form>
          </a>
        </div>
      </li>
      @else
      <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">幫助</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登入</a></li>
      @endif
    </ul>
  </div>
</nav>
