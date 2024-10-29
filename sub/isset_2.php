<?php
ob_start();

// プレビューがある場合
if(isset($_POST['preview']) && $_POST['preview'] == '1') {
?>
<!DOCTYPE html>
<html lang="jp"  dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>沖縄掲示板</title>
    </head>
    <body>
     <form action="./isset_3.php" method="POST" enctype="multipart/form-data">
        <?php
            $request = $_POST;
            $file = $_FILES["image_path"]; 
            if (!empty($file["name"])) {
                $filename = basename($file["name"]);
                $image_path = 'img/' . $filename; 
                move_uploaded_file($file['tmp_name'], $image_path);     
            } else {
                $image_path = '';
            }          
        ?>
        <h1 align="center">掲示板 Sample</h1>
        <p align="center">以下の内容でよろしければ、「このまま登校する」ボタンを押してください。<br>
        戻って修正する場合は「戻って修正するボタンでお戻り下さい。</p>
        <br>
        <table align="center" border="2" bgcolor="#EEEEEE" style="border-collapse:collapse; border-color: blue;">
                <tr>
                    <th align="left"><label for="name">名前:</label></th>
                    <td><?php echo $request['name']; ?></td>
                    <input type="hidden" name="name" value="<?php echo $request['name']; ?>">
                </tr>
                <tr>
                    <th align="left"><label for="subject">件名:</label></th>
                    <td><?php echo $request['subject']; ?></td>
                    <input type="hidden" name="subject" value="<?php echo $request['subject']; ?>">
                </tr>
                <tr>
                <th align="left">
                    <label for="message">メッセージ:<br>
                    (文字色<span style="color:<?php echo htmlspecialchars($request['color']); ?>;">■</span>)</label>
                    <input type="hidden" name="color" value="<?php echo htmlspecialchars($request['color']); ?>">
                </th>
                    <td><?php echo nl2br($request['message']); ?></td>
                    <input type="hidden" name="message" value="<?php echo nl2br($request['message']); ?>">
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
                    <td><?php echo $request['email']; ?></td>
                    <input type="hidden" name="email" value="<?php echo $request['email']; ?>">
                </tr>
                <tr>
                    <th align="left"><label for="url">ホームページ:</label></th>
                    <td><?php echo $request['url']; ?></td>
                    <input type="hidden" name="url" value="<?php echo $request['url']; ?>">
                </tr>
                <tr>
                    <th align="left"><label for="delete_key">編集/削除キー</label></th>
                    <td><?php echo $request['delete_key']; ?></td>
                    <input type="hidden" name="delete_key" value="<?php echo $request['delete_key']; ?>">
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
     //$request = http_build_query($_POST);
    $request = $_POST;
    //$file = http_build_query($_FILES["image_path"]); 
    $file = $_FILES["image_path"]; 
    if (!empty($file["name"])) {
       $filename = basename($file["name"]); 
       $image_path = 'img/' . $filename; 
       move_uploaded_file($file['tmp_name'], $image_path);     
   } else {
       $image_path = '';
   }  
   ?>
   <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>">
   <?php

   header("Location: ./isset_3.php", true, 307);

    exit;

}
ob_end_flush();
?>