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
    </div>
@endsection
@section("graph")
    <div class="container">
        <div class="row justify-content-center">
            <div style="width: 1000px;height: 5 00px">
                {{--    {{}}/{{}}<br>--}}
                今月の投稿数/総投稿数
                {{--    {{}}/{{}}<br>--}}
                今月のアクセス数/総アクセス数
                <!--chart.jsを使用-->
                <canvas id="myChart" width="100" height="50"></canvas>
                <script>
                    //チャート用データ取得
                    var url = "{{url('admin/getUserSummary')}}";//データ取得用URL
                    var date = new Array()//ラベル用日付データ
                    var userCount = new Array();//グラフ用件数データ
                    $(document).ready(function() {
                        $.get(url, function (response) {//URLにアクセス。レスポンス取得
                            response.forEach(function (summary) {//レスポンスのオブジェクトからdate,postsを取得
                                date.push(summary.date);//変数dateにレスポンスのdateを格納
                                userCount.push(summary.userCount);//変数postsにレスポンスのpostsを格納
                            });

                            //チャート生成
                            var ctx = document.getElementById("myChart");
                            var myChart = new Chart(ctx, {
                                //グラフのタイプを指定
                                type: "line",
                                //グラフの設定やデータ
                                data: {
                                    labels: date,//グラフのラベル名
                                    datasets: [{//グラフのデータ
                                        label: "ユーザー登録",//ラベルのグループ名
                                        data: userCount,
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
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        })
                    })
                </script>
            </div>
        </div>
    </div>
@endsection
