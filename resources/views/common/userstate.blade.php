@if( Auth::check() && Auth::user()->type != 'admin' )
<span class="li li-no" style="font-size:18px;color:#fff;">{{ Auth::user()->username }}，您好!</span>
<span class="li">
    <a href="{{ url('/member/auth/logout') }}">退出</a>
</span>
@else
<span class="li li-no" style="color:#fff;">游客</span>
<span class="li">
    <a href="{{ url('/member/auth/register') }}">免费注册</a>
</span>
<span class="li">
    <a href="{{ url('/member/auth/login') }}">登陆</a>
</span>
@endif