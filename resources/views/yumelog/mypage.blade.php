@extends("layouts.app2")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-6" style="text-align: left">
                <h3>アイコンアップロード</h3>
                <div>
                    @if(Auth::user()->image == null)
                        <img src="https://eaches3.s3-ap-northeast-1.amazonaws.com/images/noimage2.png">
                    @else
                        <img src="{{Auth::user()->image}}">
                    @endif
                </div>
                <form action="{{route('iconUpload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <br>
                    <input type="file" name="user_image">
                    <br>
                    <button type="submit" class="btn btn-link btn-lg">アップロード</button>
                </form>
                @foreach($errors->get('user_image') as $image_error)
                    <p style="color: red">{{$image_error}}</p>
                @endforeach
            </div>
            <div class="col-6" style="text-align: center">
                <h3>ユーザー名を変更(工事中)</h3>
            </div>
        </div>
    </div>
    <div class="title" style="margin-top: 100px">
        <h1>書いた夢日記</h1>
    </div>
    <!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
    <div class="posts">
        @foreach ($diaries as $diary)
            <div class="post">
                {{$diary->created_at}}
                <h4>{{$diary->text}}</h4>
                <form action="{{route('editDiarySession')}}" method="post" style="display: inline">
                    @csrf
                    <input type="hidden" name="editbtn" value="{{$diary->id}}"><!--ボタン押下時に送信する情報はこのタグに追加-->
                    <button type="submit" class="btn btn-link btn-lg">
                        編集
                    </button>
                </form>
                <form action="{{route('deleteDiary')}}" method="post" style="display: inline">
                    @csrf
                    <input type="hidden" name="diary_id" value="{{$diary->id}}"><!--ボタン押下時に送信する情報はこのタグに追加-->
                    <button type="submit" class="btn btn-link btn-lg" onclick="return confirm('削除しますか？')">
                        削除
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
