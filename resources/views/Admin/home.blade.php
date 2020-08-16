@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                        hello
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
