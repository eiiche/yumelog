@extends('layouts.app_admin')

@section('content')
    <h1>管理者用ログイン画面</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            <div>
                                <?php foreach($diaries as $diary){ ?>
                                {{$diary->user->name}}
                                {{$diary->created_at}}
                                <h3>{{$diary->text}}></h3>
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
