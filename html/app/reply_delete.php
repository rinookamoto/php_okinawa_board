<?php 
ob_start();
$id = $_POST['id'];

//DBに接続
if($_POST['delete_key'] === $_POST['pass']) {      
$link = mysqli_connect('mysql_db', 'root', 'root', 'okinawa_board');
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} else {
    
//削除処理
// (4)プリペアドステートメントの用意
$stmt = $link->prepare('DELETE FROM replies WHERE id = ?');

// (5)削除するidの値をセット
$stmt->bind_param('i', $id);

// (6)削除実行
$stmt->execute();

// (7)データベースとの接続解除
$link->close();

header("Location:insert.php");

}
} else {
    echo "削除できません";
    header("Location:insert.php");
}
ob_end_flush();
?>