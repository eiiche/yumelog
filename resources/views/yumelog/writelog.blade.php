<html>
<head>
    <title>Hello/Index</title>
</head>
<body>
<h1>夢日記を描く</h1>
<form method= "POST" action="/yumelog/public/yumelog">
    @csrf
    内容
    <input type="textarea"  name="text" id="text"><!--idをキーにしてコントローラーに日記テキスト受け渡し-->
    <input type="submit" value="日記を書く">
</form>
<a href="./">戻る</a>
</body>
</html>
