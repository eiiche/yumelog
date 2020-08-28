@extends('layouts.app2')

@section("content")
    @auth
            <!--スクロール表示可能な日記-->
                @foreach($diaries as $diary)
                {{$diary->user->name}}
                {{$diary->created_at}}
                <h3>{{$diary->text}}></h3>
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
    @endauth
    @guest
            @foreach($diaries as $diary)
            {{$diary->user->name}}
            {{$diary->created_at}}
            <h3>{{$diary->text}}></h3>
            @endforeach
    @endguest
@endsection
