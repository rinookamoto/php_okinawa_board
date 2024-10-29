<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['delete'])) {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>沖縄掲示板</title>
    <style>
        div {
            border: 1px solid blue;
            padding: 20px;
            margin: 30px;
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
<?php 
$id = $_POST['id'];
$delete_key = $_POST['delete_key'];
?>
    <h1 align="center">掲示板 Sample<a href="./insert.php">▲</a></h1>
    <p align = center>編集/削除キーを入力し、[送信]してください。</p>
    <div>
    <form action="./delete.php<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <p>編集/削除キー:
        <?php //$deletekey = '<input type="password" name="deletekey" required>' ;?>
        <input type="password" name="pass" value="">
        <input type="submit" value="送信"></p>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($delete_key); ?>">
        </form>
    </div>

<?php /*
$id = $_POST['id'];
var_dump($id);
?>
<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}
$deletekey = @$_POST['delete_key'];
$hashed_password = password_hash($deletekey, PASSWORD_DEFAULT);

mysqli_real_escape_string($link, $deletekey);
$sql = "INSERT INTO boards (delete_key) VALUES ('$deletekey')";
    if (mysqli_query($link, $sql)) {
        echo "\n";
    } else {
        echo "エラー: " . $sql . "<br>" . mysqli_error($link);
    }
    mysqli_close($link);
}
*/
?>
<footer>
    <hr noshade>
    <p>© RinoOkamoto 2024</p>
</footer>
</body>
</html>
<?php
    } elseif(isset($_POST['edit'])) {
        ?>
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>沖縄掲示板</title>
            <style>
                div {
                    border: 1px solid blue;
                    padding: 20px;
                    margin: 30px;
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
            <?php 
            $id = $_POST['id'];
            $delete_key = $_POST['delete_key'];
            ?>
            <h1 align="center">掲示板 Sample<a href="./insert.php">▲</a></h1>           
            <p align = center>編集/削除キーを入力し、[送信]してください。</p>
            <p>編集</p>
            <div>
            <form action="./edit.php" method="POST">
                <p>編集/削除キー:
                <input type="password" name="pass" value="">
                <input type="submit" value="送信"></p>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($delete_key); ?>">
                </form>
            </div>
        <footer>
            <hr noshade>
            <p>© RinoOkamoto 2024</p>
        </footer>
        </body>
        </html>
<?php        
    }
}
?>