<a href="#">
  <strong id="following" class="stat">
    {{ count($user->followings) }}
  </strong>
  追蹤中
</a>
<a href="#">
  <strong id="followers" class="stat">
    {{ count($user->followers) }}
  </strong>
  粉絲
</a>
<a href="#">
  <strong id="statuses" class="stat">
    {{ $user->statuses()->count() }}
  </strong>
  貼文
</a>
