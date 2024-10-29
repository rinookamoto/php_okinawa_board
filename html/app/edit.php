<?php
ob_start();
$id = $_POST['id'];
 //DBに接続(キーが正しかったら)idで選択
$link = mysqli_connect('mysql_db', 'root', 'root', 'okinawa_board');
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} else {
    echo "編集できます";
    $query = "SELECT * FROM boards WHERE id = $id";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("クエリの実行に失敗しました：" . mysqli_error($link));
    }
    $request = mysqli_fetch_assoc($result);   
    if($request['delete_key'] === $_POST['pass']) {      
    echo $request['delete_key'];
?>

<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="utf-8">
        <title>沖縄掲示板</title>
        <style>
            div {
                border: solid 2px #000;
                width: 60%;
                margin:0 auto;
                border: blue solid 1px;
                font-size: 100%; 
                padding: 30px;
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
        <form action="./update.php" method="POST" enctype="multipart/form-data">
        <h1 align="center">掲示板 Sample<a href="./insert.php">▲</a></h1>
        <div>
            <table>
                <tr>
                    <th align="left"><label for="name">名前</label></th>
                    <td><input type="text" name="name" value="<?php echo $request['name']; ?>" size="20" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="subject">件名</label></th>
                    <td><input type="text" name="subject" value="<?php echo $request['subject']; ?>" size="30" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="message">メッセージ</label></th>
                </tr> 
                <tr>
                    <td colspan="2">
                        <textarea name="message" value="" rows="7" cols="50"><?php echo htmlspecialchars($request['message']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th align="left"><label for="image_path">画像</label></th>
                    <td>
                        <input type="file" name="new_image" size="30" accept="image/*" multiple>
                    </td>   
                </tr>
                <tr>   
                    <th colspan="2" align="left">
                        <?php if (!empty($request["image_path"])){ ?>
                            <small>※新しい画像をアップロードすると、古い画像は自動的に削除されます。</small>
                    </th>
                </tr>
                <tr>    
                    <th colspan="2" align="left">▽現在の画像  (
                    <input type="checkbox" name="delete_pic" value="1">
                    この画像を削除する)
                    </th>
                </tr>
                <tr> 
                    <td colspan="2" align="left">
                        <a href="<?php echo htmlspecialchars($request["image_path"]); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($request["image_path"]); ?>" alt="画像表示">
                        </a>
                        <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($request["image_path"]); ?>">
                        <?php }  ?>
                    </td>
                </tr>                
                <tr>
                    <th align="left"><label for="email">メールアドレス</label></th>
                    <td><input type="email" name="email" value="<?php echo $request['email']; ?>" size="30" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="url">url</label></th>
                    <td><input type="url" name="url" value="<?php echo $request['url']; ?>" size="30"></td>
                </tr>
                <tr>
                    <th align="left"><label for="color">文字色</label></th>
                    <td>
                        <?php $selected_color = $request['color']; ?>
                        <input type="radio" name="color" value="red" <?php if ($selected_color === 'red') echo 'checked'; ?>><font color="red">■</font>
                        <input type="radio" name="color" value="green" <?php if ($selected_color === 'green') echo 'checked'; ?>><font color="green">■</font>
                        <input type="radio" name="color" value="blue" <?php if ($selected_color === 'blue') echo 'checked'; ?>><font color="blue">■</font>
                        <input type="radio" name="color" value="purple" <?php if ($selected_color === 'purple') echo 'checked'; ?>><font color="purple">■</font>
                        <input type="radio" name="color" value="#FF00CC" <?php if ($selected_color === '#FF00CC') echo 'checked'; ?>><font color="#FF00CC">■</font>
                        <input type="radio" name="color" value="#FF9933" <?php if ($selected_color === '#FF9933') echo 'checked'; ?>><font color="#FF9933">■</font>
                        <input type="radio" name="color" value="#000099" <?php if ($selected_color === '#000099') echo 'checked'; ?>><font color="#000099">■</font>
                        <input type="radio" name="color" value="#666666" <?php if ($selected_color === '#666666') echo 'checked'; ?>><font color="#666666">■</font>
                    </td>
                </tr>
                <tr>
                    <th align="left"><label for="delete_key">編集/削除キー</label></th>
                    <td><input type="password" name="delete_key" value="<?php echo $request['delete_key']; ?>" size="10" 
                    pattern="[0-9A-Za-z]{4,8}" maxlength="8" required>
                    <label for="delete_key"><small>(半角英数字のみで4〜8文字)</small></label></td>
                </tr>
                <tr>
                    <th align="left" colspan="2"><small>※編集時はプレビュー機能を使えません</small></th>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <td colspan="2" align="center"><input type="submit" value="編集"></td>
                </tr>
            </table>
        </div>
        </form>
        <footer>
    </body>
</html>  

<?php
} else { ?>
    <h3>編集/削除キーが正しくありません</h3>
<?php
}
}
ob_end_flush();
?>
