<?php 
// 画像の処理
$image_path = '';
//チェックボックスが押されたら
if (isset($_POST['delete_pic']) && $_POST['delete_pic'] == '1') {
    if(!empty($file_new["name"])){
        $filename_new = basename($file_new["name"]);
        $image_path = 'img/' . $filename_new; 
        move_uploaded_file($file_new['tmp_name'], $image_path);
    } else {
    $image_path = '';   
    }
} else if (isset($_FILES["new_image"])) { //チェックボックス無×画像を追加
    $file_new = $_FILES["new_image"];
    if (!empty($file_new["name"])) { //追加画像あったら
        $filename_new = basename($file_new["name"]);
        $image_path = 'img/' . $filename_new; 
        move_uploaded_file($file_new['tmp_name'], $image_path);
    }  else if (isset($_POST['image_path'])) { // $_POST['image_path'] 存在確認
        $image_path = $_POST['image_path'];
    }
}

$id = $_POST['id'];
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}
date_default_timezone_set('Asia/Tokyo');
//$week = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
//$date = "Y/m/d (";
//$time = ") H:i:s";
$create_at = date("Y/m/d  H:i:s");
$timestamp = strtotime($create_at);
$name = $_POST['name'];
$subject = $_POST['subject'];
$color = $_POST['color'];
$message = $_POST['message'];
$email = $_POST['email'];
$url = $_POST['url'];
$delete_key = $_POST['delete_key'];

$sql = "UPDATE boards SET 
        name = '$name', 
        subject = '$subject', 
        color = '$color', 
        message = '$message', 
        image_path = '$image_path', 
        email = '$email', 
        url = '$url', 
        delete_key = '$delete_key', 
        create_at = '$create_at'
        WHERE id = $id";

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
    </head>
    <body>
        <style>
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

