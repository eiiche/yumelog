<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/admin/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest("admin")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('admin.register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{Auth::guard('admin')->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-auto">
        <div class="row">
            <div class="col-2 text-center" style="margin-top:100px">
                <div class="card">
                    <div class="card-header">
                        メニュー
                    </div>
                    <div class="card-body">
                    <div class="sidebar_fixed">
                        <p><button type="button" class="btn btn-primary btn-lg" onclick="location.href='manage_users'" style="margin-top:20px;width: 50%">ユーザ管理</button></p>
                        <p><button type="button" class="btn btn-primary btn-lg" onclick="location.href='manage_diaries'" style="margin-top:20px;width: 50%">投稿管理</button></p>
                        <p><button type="button" class="btn btn-primary btn-lg" onclick="location.href='manage_admins'" style="margin-top:20px;width: 50%">管理者設定</button></p>

                        <!--ログイン関連-->
                        @if (Auth::guard('admin'))
                        <p><button type="button" class="btn btn-default btn-lg" onclick="location.href='{{route("logout")}}'" style="margin-top:40px">ログアウト</button></p>
                        @else
                        <p><button type="button" class="btn btn-default btn-lg" onclick="location.href='{{route("login")}}'" style="margin-top:40px">ログイン</button></p>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div style="margin-top:100px">
                    @yield("content")
                </div>
            </div>
            <div class="col-5">
                <div style="margin-top:100px">
                    <div class="card">
                        <div class="card-header text-center">
                            グラフ
                        </div>
                        <div class="card-body">
                            @yield("graph")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
