<?php
session_start();
ob_start();
$_SESSION['name'] = $_POST['name'];
$_SESSION['subject'] = $_POST['subject'];
$_SESSION['color'] = $_POST['color'];
$_SESSION['message'] = $_POST['message'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['url'] = $_POST['url'];
$_SESSION['delete_key'] = $_POST['delete_key'];

    if (!empty($file["name"])) {
        $filename = basename($file["name"]); 
        $image_path = 'img/' . $filename; 
        move_uploaded_file($file['tmp_name'], $image_path);     
    } else {
        $image_path = '';
    }          
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
    $color = htmlspecialchars($_POST['color'], ENT_QUOTES, 'UTF-8');
    $message = nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8'));
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $url = htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8');
    $delete_key = htmlspecialchars($_POST['delete_key'], ENT_QUOTES, 'UTF-8');
    $image_path = htmlspecialchars($_POST['image_path'], ENT_QUOTES, 'UTF-8');
    if (isset($_POST['preview']) && $_POST['preview'] == '1') {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>沖縄掲示板</title>
</head>
<body>
<form action="./session_3.php" method="POST" enctype="multipart/form-data">
    <h1 align="center">掲示板 Sample</h1>
    <p align="center">以下の内容でよろしければ、「このまま投稿する」ボタンを押してください。<br>
        戻って修正する場合は「戻って修正するボタンでお戻り下さい。</p>
    <br>
    <table align="center" border="2" bgcolor="#EEEEEE" style="border-collapse:collapse; border-color: blue;">
        <tr>
            <th align="left"><label for="name">名前:</label></th>
            <td><?php echo $name; ?></td>
            <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>">
        </tr>
        <tr>
            <th align="left"><label for="subject">件名:</label></th>
            <td><?php echo $subject; ?></td>
            <input type="hidden" name="subject" value="<?php echo $subject; ?>">
        </tr>
        <tr>
            <th align="left">
                <label for="message">メッセージ:<br>
                    (文字色<span style="color:<?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?>;">■</span>)
                </label>
                <input type="hidden" name="color" value="<?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?>">
            </th>
            <td><?php echo $message; ?></td>
            <input type="hidden" name="message" value="<?php echo $message; ?>">
        </tr>
        <tr>
            <th align="left"><label for="image_path">画像:<br>
                    <small>表示に時間がかかることがあります。</small></label></th>
            <td>
                <?php if (!empty($image_path)) { ?>
                    <img src="<?php echo htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                    <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>">
                <?php } else {?>
                    アップロードされた画像が見つかりません。
                    <input type="hidden" name="image_path" value="">
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th align="left"><label for="email">メールアドレス:</label></th>
            <td><?php echo $email; ?></td>
            <input type="hidden" name="email" value="<?php echo $email; ?>">
        </tr>
        <tr>
            <th align="left"><label for="url">ホームページ:</label></th>
            <td><?php echo $url; ?></td>
            <input type="hidden" name="url" value="<?php echo $url; ?>">
        </tr>
        <tr>
            <th align="left"><label for="delete_key">編集/削除キー</label></th>
            <td><?php echo $delete_key; ?></td>
            <input type="hidden" name="delete_key" value="<?php echo $delete_key; ?>">
        </tr>
    </table>
    <br>
    <br>
    <center>
        <button type="button" onclick="history.back()">戻って修正する</button>
        <input type="submit" value="このまま投稿する">
    </center>
</form>
</body>
</html>
<?php
} else {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['subject'] = $_POST['subject'];
    $_SESSION['color'] = $_POST['color'];
    $_SESSION['message'] = $_POST['message'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['url'] = $_POST['url'];
    $_SESSION['delete_key'] = $_POST['delete_key'];
    $_SESSION['image_path'] = $_POST['image_path'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
    $color = htmlspecialchars($_POST['color'], ENT_QUOTES, 'UTF-8');
    $message = nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8'));
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $url = htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8');
    $delete_key = htmlspecialchars($_POST['delete_key'], ENT_QUOTES, 'UTF-8');

    $image_path = htmlspecialchars($_POST['image_path'], ENT_QUOTES, 'UTF-8');
    if (!empty($_FILES["image_path"]["name"])) {
        $target_dir = 'img/';
        $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
        if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
            $image_path = htmlspecialchars($target_file, ENT_QUOTES, 'UTF-8');
        } else {
            echo "ファイルのアップロード中にエラーが発生しました。";
        }
    }
    // プレビューフラグがセットされていない場合、直接thanks.phpにリダイレクトする
    header("Location:session_3.php");
}
    ob_end_flush();
?>