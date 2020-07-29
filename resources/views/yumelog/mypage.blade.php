<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styleMypage.css') }}">
    <title>YUMELOG</title>
</head>
<body>
<h1>書いた夢日記</h1>
<!--スクロール表示可能な日記。YumelogController@mypageからログインしているユーザidに紐づいた日記が渡される-->
<div class="content">
    <?php foreach($diaries as $diary){ ?>
    {{$diary->created_at}}
    <h3>{{$diary->text}}></h3>
    <?php } ?>
</div>

<button id="square_btn" onClick="history.back()">戻る</button>
</body>
</html>
