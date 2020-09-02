@extends('layouts.app2')

@section("content")
    @auth
        <div class="board">
        <h1 class="text-center">みんなのゆめにっき</h1><br>
        <div class="text">
            <!--スクロール表示可能な日記-->
                @foreach($diaries as $diary)
                <h3 class="text">
                    <span>
                        ひづけ :
                        {{$diary->created_at}}
                        なまえ :
                        {{$diary->user->name}}
                    </span>
                </h3>
                <h3 class="text">{{$diary->text}}></h3>
                <!--お気に入りボタン-->
                <form action="yumelog/postFav" method="post" enctype='multipart/form-data'>
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
                @endforeach
        </div>
    @endauth
    @guest
            @foreach($diaries as $diary)
            {{$diary->user->name}}
            {{$diary->created_at}}
            <h3>{{$diary->text}}></h3>
            @endforeach
    @endguest
        </div>
@endsection
