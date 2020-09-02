@extends("layouts.app2")

@section("content")
    <!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
        <h1 class="text-center">お気に入りの投稿</h1>
        <?php foreach($diaries as $diary){ ?>
        {{$diary->created_at}}
        <h3>{{$diary->text}}></h3>
        <!--お気に入りボタン-->
        <form action="postFav" method="post" enctype='multipart/form-data'>
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
        <?php } ?>
@endsection
