<?php

@if (Auth::check())
    <p>user:{{$user->name . "(" . $user->email . ")"}}</p>
@else
<p>ログインしていません</p>
<a href="/login">ログイン</a>
<a href="/register">登録</a>
@endif
