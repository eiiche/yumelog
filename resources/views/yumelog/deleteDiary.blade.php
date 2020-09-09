<html>
<head>
    <title>Hello/Index</title>
</head>
<body>
<h1>削除する</h1>
<form method= "POST" action="{{route('deletedDiary')}}">
    @csrf
    <input type="hidden" name="diary_id" value="{{$diary_id}}">
    <input type="submit" value="確定">
</form>
<button id="square_btn" onClick="history.back()" onclick="">戻る</button>
</body>
</html>
