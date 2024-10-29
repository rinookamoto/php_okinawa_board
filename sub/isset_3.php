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
        </style>
        <h1 align="center">掲示板 Sample</h1>
        <br>
        <h2 align="center">投稿完了！！</h2>
        <?php 
            date_default_timezone_set('Asia/Tokyo');
            //曜日に（）をつけるのに、array内で(Sun)とつけるより日付と時間にそれぞれ（）の端をつける方が早い
            //$create_at = date('Y/m/d (D) H:i:s');
            $week = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
            $date = "Y/m/d (";
            $time = ") H:i:s";
            $create_at = date("Y/m/d  H:i:s");
            $timestamp = strtotime($create_at);
            //Unixタイムスタンプは、文字列形式の日時よりもコンピュータやプログラムでの可読性が高い場合があります。特にログの記録やデバッグ時に、Unixタイムスタンプを使用すると情報の正確性を保ちやすくなります。
            //PHPで取得した日本時間の現在時刻を、MySQLのDATETIME型に適した形式に変換して挿入する必要があり
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $color = $_POST['color'];
            $message = $_POST['message'];
            $image_path = $_POST['image_path'];
            //echo var_dump($image_path) ;

            $email = $_POST['email'];
            $url = $_POST['url'];
            $delete_key = $_POST['delete_key'];
            //("Host or IP", "User", "Pass", "DBName")
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
            //echo $_SERVER["REQUEST_METHOD"] . '<br>';
            //echo $image_path;
        ?>    
        <p align="center" class="x"><a href="./isset_1.php">投稿画面に戻る</a></p>
    </body>
</html>    