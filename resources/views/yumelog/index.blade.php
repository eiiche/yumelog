@extends('layouts.app2')

@section("content")
    @auth

        <div class="title">
            <h1>み ん な の に っ き</h1>
        </div>

            <!--スクロール表示可能な日記-->
                @foreach($diaries as $diary)
                    <div class="post" style="display: flex">
                    <div class="profile">
                        <img src="{{asset('storage/'. $diary->user->image)}}">
                        {{$diary->user->name}}
                    </div>
                <div class="post">
                  <h3 class="name float-right">
                <span class="label">
{{--                    なまえ :--}}
                </span>
                <span class="value">
                    {{$diary->user->name}}
                </span>
                  </h3>
                <h3 class="date">
                    {!! $diary->created_at->format('Y年m月d日h時m分') !!}
                </h3>
                <h3 class="text">
                    {{$diary->text}}
                </h3>

                <!--お気に入りボタン-->
                <form action="{{route('postFav')}}" method="post" enctype='multipart/form-data' class="form">
                    @csrf
                    <input type="hidden" name="favoritebtn" value="{{$diary->id}}">
                    <button type="submit" class="favorite btn btn-default">
                        @if($faves->contains($diary->id))
                            ★
                        @else
                            ☆
                        @endif
                    </button>
                </form>
                </div>
                    </div>
                @endforeach

    @endauth
    @guest
        <div class="title">
            <h1>み ん な の に っ き</h1>
        </div>

        <!--スクロール表示可能な日記-->
        @foreach($diaries as $diary)
            <div class="post">
                <h3 class="name float-right">
                <span class="label">
                </span>
                    <span class="value">
                    {{$diary->user->name}}
                </span>
                </h3>
                <h3 class="date">
                    {!! $diary->created_at->format('Y年m月d日h時m分') !!}
                </h3>
                <h3 class="text">
                    {{$diary->text}}
                </h3>
            </div>
        @endforeach
    @endguest
@endsection
