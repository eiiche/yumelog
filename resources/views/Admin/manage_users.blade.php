@extends('layouts.app_admin')
@section('content')

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
                                <form method= "POST" action="user_checkbox">
                                    @csrf
                                <table class="table">
                                    <tr><th></th><th>会員id</th><th>名前</th><th>メールアドレス</th><th>登録日</th><th>更新日</th></tr>
                                    @foreach($users as $user)
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox" value="{{$user->id}}" name="user_id[]"></td>
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
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-lg" onclick="return confirm('削除しますか？')">削除する</button>
                                    <button type="submit" name="action" value="mail" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalMailForm">メール配信</button>
                                </form>
                                {{$users->links()}}
                            </div>
                    </div>
                </div>

    <!--mailing modal-->
                <div class="modal fade" id="modalMailForm" tabindex="-1" role="dialog" aria-labelledby="modalMailFormLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="sendMail">
                                    <p>件名</p>
                                    <textarea name="" id="" cols="50" rows="2"></textarea>
                                    <p>本文</p>
                                    <textarea name="" id="" cols="50" rows="10"></textarea>
                                    <button type="submit"></button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

@endsection
@section("graph")

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

@endsection
