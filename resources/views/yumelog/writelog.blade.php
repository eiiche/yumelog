@extends("layouts.app2")

@section("content")
    <div class="title">
        <h1>日記を書く</h1>
    </div>

    @if($errors->has('text'))
        @foreach($errors->get('text') as $text_error)
            <p style="color: red">{{$text_error}}</p>
        @endforeach
    @endif

    <form method= "POST" action="{{route('wroteDiary')}}" class="text-center" >
        @csrf
        <textarea class="form-control" id="text" rows="10" name="text"></textarea><!--name="id"をキーにしてコントローラーに日記テキスト受け渡し-->
        <br>
        <input type="submit" value="投稿する" class="btn btn-default btn-lg">
    </form>
@endsection
