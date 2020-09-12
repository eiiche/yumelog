@extends("layouts.app2")

@section("content")
    <div class="title">
        <h1>書いた夢日記</h1>
    </div>
    <!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
        @foreach ($diaries as $diary)
    <div class="post">
        {{$diary->created_at}}
        <h3>{{$diary->text}}</h3>
        <form action="{{route('editDiarySession')}}" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="editbtn" value="{{$diary->id}}"><!--ボタン押下時に送信する情報はこのタグに追加-->
            <button type="submit" class="btn btn-link btn-lg">
                編集
            </button>
        </form>
        <form action="{{route('deleteDiary')}}" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="diary_id" value="{{$diary->id}}" ><!--ボタン押下時に送信する情報はこのタグに追加-->
            <button type="submit" class="btn btn-link btn-lg" onclick="return confirm('削除しますか？')">
                削除
            </button>
        </form>
    </div>
        @endforeach
@endsection
