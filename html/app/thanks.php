<?php
date_default_timezone_set('Asia/Tokyo');
//曜日に（）をつけるのに、array内で(Sun)とつけるより日付と時間にそれぞれ（）の端をつけている
//$create_at = date('Y/m/d (D) H:i:s');
//$week = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
//$date = "Y/m/d (";
//$time = ") H:i:s";
$create_at = date("Y/m/d  H:i:s");
$timestamp = strtotime($create_at);
//Unixタイムスタンプは、文字列形式の日時よりもコンピュータやプログラムでの可読性が高い場合がある。ログの記録やデバッグ時、Unixタイムスタンプを使うと情報の正確性を保ちやすくなる。
//PHPで取得した日本時間の現在時刻を、MySQLのDATETIME型に適した形式に変換して挿入する必要がある
$name = $_POST['name'];
$subject = $_POST['subject'];
$color = $_POST['color'];
$message = $_POST['message'];
$image_path = $_POST['image_path'];
$email = $_POST['email'];
$url = $_POST['url'];
$delete_key = $_POST['delete_key'];
//データベースに入れる
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}
$sql = "INSERT INTO boards (name, subject, color, message, image_path, email, url, delete_key, create_at) 
VALUES ('{$name}', '{$subject}', '{$color}', '{$message}', '{$image_path}', '{$email}', '{$url}', '{$delete_key}', '{$create_at}')";
if (mysqli_query($link, $sql)) {
    echo "\n";
} else {
    echo "エラー: " . $sql . "<br>" . mysqli_error($link);
}
?>

<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="utf-8">
        <title>沖縄掲示板</title>
        <style>
            footer {
                width: 100%;
                height: 20px; 
                text-align: center;
                padding: 50px 0;
            }
        </style>
    </head>
    <body>
        <style>
            .x {
                padding-top: 200px;
            }
        </style>
        <h1 align="center">掲示板 Sample<a href="./insert.php">▲</a></h1>
        <br>
        <h2 align="center">投稿完了！！</h2>
        <p align="center" class="x"><a href="./insert.php">投稿画面に戻る</a></p>
        <footer>
        <hr noshade>
        <p>© RinoOkamoto 2024</p>
        </footer>
    </body>
</html>    

