@extends("layouts.app2")

@section("content")
    <h1>書いた夢日記</h1><br>
    <!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
        <?php foreach($diaries as $diary){ ?>
        {{$diary->created_at}}
        <h3>{{$diary->text}}></h3>
            <div>
        <form action="editDiary" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="editbtn" value="{{$diary->id}}"><!--ボタン押下時に送信する情報はこのタグに追加-->
            <button type="submit" class="btn btn-link btn-lg">
                編集
            </button>
        </form>
        <form action="deleteDiary" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="deletebtn" value="{{$diary->id}}"><!--ボタン押下時に送信する情報はこのタグに追加-->
            <button type="submit" class="btn btn-link btn-lg">
                削除
            </button>
        </form>
            </div>
        <?php } ?>
@endsection
