<?php
date_default_timezone_set('Asia/Tokyo');
$week = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
$date = "Y/m/d (";
$time = ") H:i:s";
$create_at = date("Y/m/d  H:i:s");
$timestamp = strtotime($create_at);
$id = $_POST['id'];
$name = $_POST['name'];
$subject = $_POST['subject'];
$color = $_POST['color'];
$message = $_POST['message'];
$image_path = $_POST['image_path'];
$email = $_POST['email'];
$url = $_POST['url'];
$delete_key = $_POST['delete_key'];
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} //repliesテーブルのboard_id
$sql = "INSERT INTO replies (board_id, name, subject, color, message, image_path, email, url, delete_key, create_at) 
VALUES ('{$id}', '{$name}', '{$subject}', '{$color}', '{$message}', '{$image_path}', '{$email}', '{$url}', '{$delete_key}', '{$create_at}')";
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
            .x {
                padding-top: 200px;
            }
            footer {
                width: 100%;
                height: 20px; 
                text-align: center;
                padding: 50px 0;
            }
        </style>
    </head>
    <body>
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