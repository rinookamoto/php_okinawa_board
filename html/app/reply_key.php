<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['delete'])) {
//削除画面へ 
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
    <form action="./reply_delete.php" method="POST">
        <p>編集/削除キー:
        <input type="password" name="pass" value="">
        <input type="submit" value="送信">
        </p>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($delete_key); ?>">
    </form>
    </div>
</body>
</html>

<?php
    } elseif(isset($_POST['edit'])) {
     //編集画面へ
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
        <form action="./reply_edit.php" method="POST">
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