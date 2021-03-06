@extends("layouts.app2")

@section("content")
    @if($diaries->isEmpty())
        <p class="flash_message text-center py-3 my-0" style="background:rgba(170,145,172 ,0.5)">お気に入りした投稿がありません</p>
    @endif

    <!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
    <div class="title">
        <h1>お気に入りした投稿</h1>
    </div>

    @foreach ($diaries as $diary)
        <div class="post">
            {{$diary->created_at}}
            <h4>{{$diary->text}}></h4>
            <!--お気に入りボタン-->
            <form action="{{route('postFav')}}" method="post" enctype='multipart/form-data'>
                @csrf
                <input type="hidden" name="favoritebtn" value="{{$diary->id}}">
                <button type="submit" class="btn btn-link btn-sm">
                    @if($faves->contains($diary->id))
                        <h3>★</h3>
                    @else
                        <h3>☆</h3>
                    @endif
                </button>
            </form>
        </div>
    @endforeach
@endsection
