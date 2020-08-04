<html>
<head>
    <title>Hello/Index</title>
</head>
<body>
<h1>お気に入りの投稿</h1>
<?php foreach($diaries as $diary){ ?>
{{$diary->created_at}}
<h3>{{$diary->text}}></h3>
<?php } ?>
<button id="square_btn" onClick="history.back()">戻る</button>
</body>
</html>
