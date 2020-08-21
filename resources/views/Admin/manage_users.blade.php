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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="menu_parent">
                    <h2>管理画面</h2>
                    <a href="home">TOP</a>
                    <div class="menu1">
                        <h3>テーブル</h3>
                        <a href="manage_users">users</a><br>
                        <a href="manage_diaries">diaries</a><br>
                        <a href="manage_favorites">favorites</a><br>
                        <a href="manage_access_log">access_logs</a><br>
                        <a href="manage_admin_log">admin_logs</a><br>
                        <a href="manage_admins">admins</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Employee Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!--検索メニュー-->
                        <div>
                            <form method= "POST" action="manage_users">
                                @csrf
                                ID,名前,メールアドレス検索
                                <input type="text"  name="search_text" id="search_text">
                                <input type="submit" value="検索">
                            </form>
                        </div>

                            <!--一覧表示-->
                            <div class="container">
                                <table class="table">
                                 <tr><th>会員id</th><th>名前</th><th>メールアドレス</th><th>登録日</th><th>更新日</th></tr>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                        {{--<td>{{$user->email_verified_at}}</td>--}}
                                        {{--<td >{{$user->password}}</td>--}}
                                            <td>{{$user->created_at}}</td>
                                            <td>{{$user->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
