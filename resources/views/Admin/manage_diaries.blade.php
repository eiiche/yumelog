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
                        テーブル閲覧
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                    @endif
                        <!--検索メニュー-->
                            <div>
                                <form method= "POST" action="manage_diaries">
                                    @csrf
                                    日記ID・投稿文検索
                                    <input type="text"  name="search_text" id="search_text" style="width: 10%">
                                    投稿者ID検索
                                    <input type="text"  name="author_id" id="author_id" style="width: 10%">
                                    投稿日時指定
                                    Since:
                                    <input type="date" name="since_date" id="since_date" style="width: 15%">
                                    Until:
                                    <input type="date" name="until_date" id="until_date"style="width: 15%">
                                    <input type="submit" value="検索">
                                </form>
                            </div>
                            <div class="container">
                                <table class="table">
                                    <tr><th>日記id</th><th>投稿文</th><th>投稿者ID</th><th>投稿日</th><th>更新日</th></tr>
                                    @foreach($diaries as $diary)
                                        <tr>
                                            <td style="width: 10%">{{$diary->id}}</td>
                                            <td style="width: 60%;overflow: scroll">{{$diary->text}}</td>
                                            <td style="width: 10%;">{{$diary->author_id}}</td>
                                            <td style="width: 10%;">{{$diary->created_at}}</td>
                                            <td style="width: 10%;">{{$diary->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
        @section("graph")
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <!--chart.jsを使用-->
                        <canvas id="myChart" width="100" height="50"></canvas>
                        <script>
                            //チャート用データ取得
                            var url = "{{url('admin/getDiarySummary')}}";//データ取得用URL
                            var date = new Array()//ラベル用日付データ
                            var posts = new Array();//グラフ用件数データ
                            $(document).ready(function() {
                                $.get(url, function (response) {//URLにアクセス。レスポンス取得
                                    response.forEach(function (postCount) {//レスポンスのオブジェクトからdate,postsを取得
                                        date.push(postCount.date);//変数dateにレスポンスのdateを格納
                                        posts.push(postCount.posts);//変数postsにレスポンスのpostsを格納
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
                                                label: "投稿数",//ラベルのグループ名
                                                data: posts,
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

