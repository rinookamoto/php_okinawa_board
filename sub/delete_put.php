<?php 
ob_start();
/*
$id = $_POST['id'];

<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$link = mysqli_connect("mysql_db", "root", "root", "okinawa_board");
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}
$deletekey = $_POST['delete_key'];
$hashed_password = password_hash($deletekey, PASSWORD_DEFAULT);

$deletekey_escaped = mysqli_real_escape_string($link, $deletekey);

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

<?php
//$delete = $_POST['delete'];

$id = $_POST['id'];
//var_dump($_POST);

//DBに接続
if($_POST['delete_key'] === $_POST['pass']) {      
$link = mysqli_connect('mysql_db', 'root', 'root', 'okinawa_board');
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} else {
    
//削除処理
// (4)プリペアドステートメントの用意
$stmt_re = $link->prepare('DELETE FROM replies WHERE board_id = ?');
$stmt = $link->prepare('DELETE FROM boards WHERE id = ?');

// (5)削除するidの値をセット
$board_id = $_POST['id']; 
$stmt_re->bind_param('i', $board_id);
$stmt->bind_param('i', $id);

// (6)削除実行
$stmt_re->execute();
$stmt->execute();

// (7)データベースとの接続解除
$link->close();

header("Location:insert.php");

}
} else {
    echo "削除できません";
    header("Location:insert.php");
/*$sql_delete = "DELETE FROM boards WHERE id = '$id';";

     (mysqli_query($link, $sql_delete));

    } else {
        echo "削除できません";
        //header("Location:delete_edit.php");
    }
    mysqli_close($link);

   //header("Location:insert.php");
*/
}
ob_end_flush();
?>
