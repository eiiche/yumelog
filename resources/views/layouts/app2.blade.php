<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">

    <!--chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm fixed-top nav">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/yumelog') }}" style="color: white">
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
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: white">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item bg-dark" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: white">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <div class="background">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="sidebar_fixed text-center" style="padding-top:75px">
                                    <p><button type="button" class="btn-note1" onclick="location.href='/yumelog/public/yumelog/writelog'" style="margin-top:40px">日記を書く</button></p>
                                    <p><button type="button" class="btn-note2" onclick="location.href='/yumelog/public/yumelog/mypage'" style="margin-top:40px">マイページ</button></p>
                                    <p><button type="button" class="btn-note2" onclick="location.href='/yumelog/public/yumelog/favorite'" style="margin-top:40px">お気に入り</button></p>

                                <!--ログイン関連-->
                                <?php if(Auth::check()){ ?>
                                <p><button type="button" class="btn-note2" onclick="location.href='logout'" style="margin-top:40px">ログアウト</button></p>
                                <?php }else{ ?>
                                <p><button type="button" class="btn-note2" onclick="location.href='login'" style="margin-top:40px">ログイン</button></p>
                                <p><button type="button" class="btn-note2" onclick="location.href='register'" style="margin-top:40px">登録</button></p>
                                <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div  class="content-parent">
                        @yield("content")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
