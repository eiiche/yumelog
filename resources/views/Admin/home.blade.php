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

                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    {{}}/{{}}<br>--}}
    今月の投稿数/総投稿数
{{--    {{}}/{{}}<br>--}}
    今月のアクセス数/総アクセス数
    <!--chart.jsを使用-->
    <canvas id="myChart" width="400" height="400"></canvas>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            //グラフのタイプを指定
            type: "line",
            //グラフの設定やデータ
            data: {
                labels : ["青"],//グラフのラベルの色名
                datasets : [{//グラフのデータ
                    label: "投稿数",//ラベルの表示
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [//色指定
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            //グラフのオプション設定
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection

