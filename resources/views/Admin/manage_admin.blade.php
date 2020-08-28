@extends('layouts.app_admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="menu_parent">
                    <h2>管理画面</h2>
                    <a href="home">TOP</a>
                    <div class="menu1">
                        <h3>テーブル</h3>
                        <a href="manage_users">users一覧</a><br>
                        <a href="manage_diaries">diaries一覧</a><br>
                        <a href="manage_favorites">favorites一覧</a><br>
                        <a href="manage_access_log">access_logs一覧</a><br>
                        <a href="manage_admin_log">admin_logs一覧</a><br>
                        <a href="manage_admins">admins一覧</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">


                    </div>

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
                                <tr><th>管理者id</th><th>名前</th><th>メールアドレス</th><th>登録日</th><th>更新日</th></tr>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{$admin->id}}</td>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->email}}</td>
                                        {{--<td>{{$user->email_verified_at}}</td>--}}
                                        {{--<td >{{$user->password}}</td>--}}
                                        <td>{{$admin->created_at}}</td>
                                        <td>{{$admin->updated_at}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
