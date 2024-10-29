<?php 
//var_dump($_POST);
//var_dump($_FILES);

// 画像の処理
$image_path = '';
if (isset($_POST['delete_pic']) && $_POST['delete_pic'] == '1') {
    $image_path = '';   
} else if (isset($_FILES["new_image"])) {
    $file_new = $_FILES["new_image"];
    if (!empty($file_new["name"])) {
        $filename_new = basename($file_new["name"]);
        $image_path = 'img/' . $filename_new; 
        move_uploaded_file($file_new['tmp_name'], $image_path);
    }  else if (isset($_POST['image_path'])) { // $_POST['image_path'] が存在するか確認する
        $image_path = $_POST['image_path'];
    }
}

$id = $_POST['id'];

/*
date_default_timezone_set('Asia/Tokyo');

$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} else {
    mysqli_select_db($link,"okinawa_board");
    $query = "SELECT * FROM boards WHERE id = $id";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("クエリの実行に失敗しました：" . mysqli_error($link));
    }
    $request = mysqli_fetch_assoc($result);



if(isset($_POST['delete_pic']) && $_POST['delete_pic'] == '1') {
    
}
*/


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
//$image_path = $_POST['image_path'];
//echo var_dump($image_path) ;
$email = $_POST['email'];
$url = $_POST['url'];
$delete_key = $_POST['delete_key'];
//$file = $_FILES["image_path"]; 
/*画像入れる
        if (!empty($file["name"])) {
            $filename = basename($file["name"]);
            $image_path = 'img/' . $filename; 
            move_uploaded_file($file['tmp_name'], $image_path);     
        } else {
            $image_path = '';
        }          

/*$image_path = '';
if (!empty($_FILES["image_path"]["name"])) {
    $filename = basename($_FILES["image_path"]["name"]);
    $file_path = 'img/' . $filename;
    if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $file_path)) {
        $image_path = $file_path;
    } else {
        echo "ファイルのアップロードに失敗しました。";
    }
}
*/

/*
if(isset($_POST['delete_pic']) && $_POST['delete_pic'] == '1') {
    $image_path = '';    
} else {
    // ファイルがアップロードされた場合の処理
    if (isset($_FILES["image_path"])) {
        $file = $_FILES["image_path"];
        if (!empty($file["name"])) {
            // ファイル名を取得して保存先のパスを設定
            $filename = basename($file["name"]);
            $image_path = 'img/' . $filename; 
            
            // ファイルを移動する
            if (move_uploaded_file($file['tmp_name'], $image_path)) {
                echo "ファイルのアップロードに成功しました。";
            } else {
                echo "ファイルのアップロードに失敗しました。";
                $image_path = ''; // 失敗した場合は画像パスを空にする
            }
        } else {
            $image_path = ''; // ファイルが指定されていない場合も空にする
        }
    }
}
*////


////

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


/*
$stmt = $link->prepare("UPDATE boards SET 
                        name = ?,
                        subject = ?,
                        color = ?,
                        message = ?,
                        image_path = ?,
                        email = ?,
                        url = ?,
                        delete_key = ?,
                        create_at = ?
                        WHERE id = ?");
$stmt->bind_param('sssssssssi', $name, $subject, $color, $message, $image_path, $email, $url, $delete_key, $create_at, $id);

if ($stmt->execute()) {
    echo "更新が完了しました。";
} else {
    echo "エラー: " . $stmt->error;
}

$stmt->close();
$link->close();
*/
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
        <h1 align="center">掲示板 Sample<a href="./insert.php">▲</a></h1>        <br>
        <h2 align="center">投稿完了！！</h2>
        <p align="center" class="x"><a href="./insert.php">投稿画面に戻る</a></p>
    <footer>
        <hr noshade>
        <p>© RinoOkamoto 2024</p>
    </footer>

    </body>
</html>    

