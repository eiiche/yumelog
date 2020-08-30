@extends("layouts.app2")

@section("content")
    <h1>夢日記を描く</h1>

    <form method= "POST" action="/yumelog/public/yumelog" >
        @csrf
        <textarea class="form-control" id="text" rows="3" name="text"></textarea><!--name="id"をキーにしてコントローラーに日記テキスト受け渡し-->
        <br>
        <input type="submit" value="投稿する" class="btn btn-default btn-lg">
    </form>
@endsection
