@extends('layouts.app2')

@section("content")
    @auth
        <!--スクロール表示可能な日記-->
        @foreach($diaries as $diary)
            <div class="posts">
                <div class="post" style="display: flex">
                    <div class="profile" style="display: flex; flex-direction: column; text-align: center">
                        @if($diary->user->image != null)
                            <img src="{{$diary->user->image}}" width="60px" height="60px"
                                 class="iconImage">
                        @else
                            <img src="https://eaches3.s3-ap-northeast-1.amazonaws.com/images/noimage2.png" width="60px" height="60px" class="iconImage">
                        @endif
                        {{$diary->user->name}}
                    </div>
                    <div style="margin-left: 100px">
                        <h5 class="date">
                            {!! $diary->created_at->format('Y年m月d日h時m分') !!}
                        </h5>
                        <h4 class="text">
                            {{$diary->text}}
                        </h4>

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
            </div>
        @endforeach

    @endauth
    @guest

        <!--スクロール表示可能な日記-->
        @foreach($diaries as $diary)
            <div class="posts">
                <div class="post" style="display: flex">
                    <div class="profile" style="display: flex; flex-direction: column; text-align: center">
                        @if($diary->user->image != null)
                            <img src="{{$diary->user->image}}" width="60px" height="60px"
                                 class="iconImage">
                        @else
                            <img src="https://eaches3.s3-ap-northeast-1.amazonaws.com/images/noimage2.png" width="60px" height="60px" class="iconImage">
                        @endif
                        {{$diary->user->name}}
                    </div>
                    <div style="margin-left: 100px">
                        <h5 class="date">
                            {!! $diary->created_at->format('Y年m月d日h時m分') !!}
                        </h5>
                        <h4 class="text">
                            {{$diary->text}}
                        </h4>
                    </div>
                </div>
            </div>
        @endforeach
    @endguest
@endsection
