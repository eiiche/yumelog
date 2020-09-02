@extends('layouts.app2')

@section("content")
    @auth
        <div class="board">
        <div class="title"><h1>ゆ  め  ロ  グ</h1>
            <h4 class="subtitle">み ん な の ゆ め に っ き</h4>
        </div>
        <div class="content">
            <!--スクロール表示可能な日記-->
                @foreach($diaries as $diary)

                <h3 class="name">
                    なまえ :
                    {{$diary->user->name}}
                </h3>
                <h3 class="date">
                    {{$diary->created_at->format('Y年m月d日h時m分')}}
                </h3>
                <h3>
                    {{$diary->text}}
                </h3>
                <!--お気に入りボタン-->
                <form action="yumelog/postFav" method="post" enctype='multipart/form-data' class="form">
                    @csrf
                    <input type="hidden" name="favoritebtn" value="{{$diary->id}}">
                    <button type="submit" class="favorite">
                        @if($faves->contains($diary->id))
                            ★
                        @else
                            ☆
                        @endif
                    </button>
                </form>
                @endforeach
        </div>
    @endauth
    @guest
            @foreach($diaries as $diary)
                    <h3 class="date">
                        {{$diary->user->name}}
                    </h3>
                    <h3 class="date">
                        {{$diary->created_at}}
                    </h3>
            <h3 class="text">
                {{$diary->text}}
            </h3>
            @endforeach
    @endguest
        </div>
@endsection
