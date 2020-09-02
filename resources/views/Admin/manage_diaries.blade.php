@extends('layouts.app_admin')
@section('content')
                <div class="card">
                    <div class="card-header text-center">
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
                                <form method= "POST" action="diary_multiple_delete">
                                    @csrf
                                <table class="table">
                                    <tr><th></th><th>日記id</th><th>投稿文</th><th>投稿者ID</th><th>投稿日</th><th>更新日</th></tr>
                                    @foreach($diaries as $diary)
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox" value="{{$diary->id}}" name="diary_id[]"></td>
                                            <td style="width: 10%">{{$diary->id}}</td>
                                            <td style="width: 60%;overflow: scroll">{{$diary->text}}</td>
                                            <td style="width: 10%;">{{$diary->author_id}}</td>
                                            <td style="width: 10%;">{{$diary->created_at}}</td>
                                            <td style="width: 10%;">{{$diary->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                    <input type="submit" value="削除する" class="btn btn-danger btn-lg" name="delete" onclick="return confirm('削除しますか？')">
                                </form>
                                <div style="padding-top:25px">
                                {{$diaries->links()}}
                                </div>
                                <form action="{{route("export_csv")}}" method="post" style="display: inline">
                                    @csrf
                                    <input type="hidden" name="table" value="diary">
                                    <button type="submit" class="btn btn-default btn-lg">CSVエクスポート</button>
                                </form>
                                    <button type="button" value="diary" name="table" class="btn btn-default btn-lg" data-toggle="modal" data-target="#modalCSVForm">CSVインポート</button>
                            </div>
                    </div>
                </div>

                <!--CSV upload modal-->
                <div class="modal fade" id="modalCSVForm" tabindex="-1" role="dialog" aria-labelledby="modalCSVFormLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route("import_csv")}}" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="file" name="csv">
                                    <input type="hidden" name="table" value="diary">
                                    <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger btn-lg" >送信する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

@endsection
        @section("graph")
                        <!--chart.jsを使用-->
                        <canvas id="myChart" width="100" height="50"></canvas>
                        <script>
                            //チャート用データ取得
                            var url = "{{url('admin/getDiarySummary')}}";//データ取得用URL
                            var date = new Array()//ラベル用日付データ
                            var postCount = new Array();//グラフ用件数データ
                            $(document).ready(function() {
                                $.get(url, function (response) {//URLにアクセス。レスポンス取得
                                    response.forEach(function (result) {//レスポンスのオブジェクトからdate,postsを取得
                                        date.push(result.date);//変数dateにレスポンスのdateを格納
                                        postCount.push(result.postCount);//変数postsにレスポンスのpostsを格納
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
                                                data: postCount,
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

        @endsection

