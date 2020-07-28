<!doctype html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>YUMELOG</title>
</head>
<body>
<!--画面上部に固定されるヘッダー-->
<header class="titlelogo">
        <h1>ゆ　め　ろ　ぐ</h1>
        <p>み　ん　な　の　ゆ　め　に　っ　き</p>
</header>

<div class="container">
        <!--サイドバー-->
    <div class="sidebar">
        <ul>
            <li>
                <a href="yumelog/writelog">日記を書く</a>
            </li>
            <li>
                <a href="yumelog/mypage">マイページ</a>
            </li>
            <li>
                <a href="yumelog/favorite">お気に入り</a>
            </li>
            <!--ログインチェックはミドルウェアかクッキーに処理を移行した方が良さそう-->
            <?php if(Auth::check()){ ?>
            <p>User:{{$user->name}}</p>
            <?php }else{ ?>
            <p><a href="login">ログイン</a></p>
            <a href="register">登録</a>
            <?php } ?>

        </ul>
    </div>

    <!--スクロール表示可能な日記-->
    <div class="content">
        <?php foreach($diaries as $diary){ ?>
        <h1>test</h1>
        <?php } ?>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
