<?php
session_start();

// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// 曜日の日本語表記の配列
$week = array("日", "月", "火", "水", "木", "金", "土");

// 現在の日時を取得し、MySQLのDATETIME形式に変換
$create_at = date('Y-m-d H:i:s');

// セッションからデータを取得
$name = $_SESSION['name'];
$subject = $_SESSION['subject'];
$color = $_SESSION['color'];
$message = $_SESSION['message'];
$email = $_SESSION['email'];
$url = $_SESSION['url'];
$delete_key = $_SESSION['delete_key'];
$image_path = $_SESSION['image_path'];
var_dump($_SESSION);


// MySQLに接続
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}

// SQLクエリを作成して実行（create_at の値を変更）
$sql = "INSERT INTO boards (name, subject, color, message, image_path, email, url, delete_key, create_at) 
        VALUES ('{$name}', '{$subject}', '{$color}', '{$message}', '{$image_path}', '{$email}', '{$url}', '{$delete_key}', '{$create_at}')";

if (mysqli_query($link, $sql)) {
    echo "\n";
} else {
    echo "エラー: " . $sql . "<br>" . mysqli_error($link);
}

// セッションをクリアして破棄
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>沖縄掲示板</title>
</head>
<body>
<style>
    .x {
        padding-top: 200px;
    }
</style>
<h1 align="center">掲示板 Sample</h1>
<br>
<h2 align="center">投稿完了！！</h2>
<p align="center" class="x"><a href="./session_1.php">投稿画面に戻る</a></p>
</body>
</html>
