<html>
<head>
    <title>Hello/Index</title>
</head>
<body>
<h1>編集する</h1>
<form method= "POST" action="editedDiary">
    @csrf
    <input type="hidden" name="diary_id" value="{{$diary->id}}">
    <input type="textarea"  name="text" rows="4" cols="40" id="text" value={{$diary->text}}><!--idをキーにしてコントローラーに編集した日記テキスト受け渡し-->
    <input type="submit" value="編集を確定">
</form>
<button id="square_btn" onClick="history.back()">戻る</button>
</body>
</html>
