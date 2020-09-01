

@extends("layouts.app2")

@section("content")
    <h1>編集する</h1>
    <form method= "POST" action="editedDiary">
        @csrf
        <input type="hidden" name="diary_id" value="{{$diary->id}}">
        <textarea class="form-control" id="text" rows="3" name="text" value="{{$diary->text}}"></textarea><!--idをキーにしてコントローラーに編集した日記テキスト受け渡し-->
        <input type="submit" value="編集を確定">
    </form>
@endsection
