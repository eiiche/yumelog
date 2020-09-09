@extends('layouts.app_admin_home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        ログインユーザ
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            {{Auth::user()->name}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

