<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="utf-8">
        <title>沖縄掲示板</title>
        <style>
            div {
                border: solid 2px #000;
                width: 80%;
                height: 80%;
                margin:0 auto;
                border: blue solid 1px;
                font-size: 100%; 
                padding: 30px;
            }
            .r {
                background-color: #EEEEEE;
            }
        </style>
    </head>
    <body>
        <form action="./session_2.php" method="POST" enctype="multipart/form-data">

        <h1 align="center">掲示板 Sample</h1>
        <div>
            <table>
                <tr>
                    <th align="left"><label for="name">名前</label></th>
                    <td><input type="text" name="name" value="" size="20" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="subject">件名</label></th>
                    <td><input type="text" name="subject" value="" size="30" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="message">メッセージ</label></th>
                </tr> 
                <tr>
                    <td colspan="2"><textarea name="message" rows="7" cols="50"></textarea></td>
                </tr>
                <tr>
                    <th align="left"><label for="image_path">画像</label></th>
                    <td><input type="file" name="image_path" size="30" accept="image/*" multiple></td>
                </tr>
                <tr>
                    <th align="left"><label for="email">メールアドレス</label></th>
                    <td><input type="email" name="email" value="" size="30" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="url">url</label></th>
                    <td><input type="url" name="url" value="" size="30"></td>
                </tr>
                <tr>
                    <th align="left"><label for="color">文字色</label></th>
                    <td>
                        <input type="radio" name="color" value="red" checked><font color="red">■</font>
                        <input type="radio" name="color" value="green"><font color="green">■</font>
                        <input type="radio" name="color" value="blue"><font color="blue">■</font>
                        <input type="radio" name="color" value="purple"><font color="purple">■</font>
                        <input type="radio" name="color" value="#FF00CC"><font color="#FF00CC">■</font>
                        <input type="radio" name="color" value="#FF9933"><font color="#FF9933">■</font>
                        <input type="radio" name="color" value="#000099"><font color="#000099">■</font>
                        <input type="radio" name="color" value="#666666"><font color="#666666">■</font>
                    </td>
                </tr>
                <tr>
                    <th align="left"><label for="delete_key">編集/削除キー</label></th>
                    <td><input type="password" name="delete_key" value="" size="10" 
                    pattern="[0-9A-Za-z]{4,8}" maxlength="8" required>
                    <label for="delete_key"><small>(半角英数字のみで4〜8文字)</small></label></td>
                </tr>
                <tr>
                    <th colspan="2"><input type="checkbox" name="preview" value="1">
                    プレビューする<small>（投稿前に、内容をプレビューして確認できます）</small></th>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="投稿">
                    <input type="reset" value="リセット"></td>
                </tr>
            </table>
        </div>
        </form>
        <br>
        <br>
        <?php   
                $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
                if (mysqli_connect_errno()) {
                    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
                } 
               mysqli_select_db($link,"okinawa_board");
               $result = mysqli_query($link, "SELECT * FROM boards;");
                if (!$result) {
                    die("クエリの実行に失敗しました：" . mysqli_error($link));
                }      
        $result = mysqli_query($link, "SELECT * FROM boards ORDER BY id DESC;");
        while ($row = mysqli_fetch_assoc($result)) {    
            echo "<div class='r'>";
            echo $row["subject"];
            echo " - ";
            echo '<a href="mailto:' . htmlspecialchars($row["email"]) . '">' . htmlspecialchars($row["name"]) . '</a>';
            echo '&nbsp';
            if (!empty($row["url"])){
                echo '<a href="' . htmlspecialchars($row["url"]) . '">URL</a>'."<br>";
            }
            date_default_timezone_set('Asia/Tokyo');    
            $week = array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
            $date = "Y/m/d (";
            $time = ") H:i:s";
            $create_at = $row["create_at"];
            $timestamp = strtotime($create_at);
            ?><p align="right"><?php echo date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp)."<br>" ?></p> <?php ;
            echo '<span style="color: ' . htmlspecialchars($row['color']) . ';">' . htmlspecialchars($row['message']) . '</span>'. "<br>";
            if (!empty($row["image_path"])) {
                ?><a href="<?php echo htmlspecialchars($row["image_path"]); ?>" target="_blank">
                <?php
                echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="画像表示不可">';
            }
            ?></a><?php

            echo "<br>";            
            ?>
            <!--echo $row["delete_key"]."<br>";-->
            <!--<form action="./delete_edit.php" method="POST" enctype="multipart/form-data">-->
            <p align="right">
            <button type="submit" name="reply">返信</button>
            <button type="submit" name="delete">削除</button>
            <button type="submit" name="edit">編集</button>
            </p>
            <!--</form>-->
            <?php
            echo "</div>"; 
            echo "<br>";

            //$date = new DateTime($row[‘created_at’]);
            //$day_of_week = $date->format(‘D’);
            //$formatted_date = $date->format('Y/m/d (D) H:i:s');
        }

        mysqli_free_result($result);
        ?>        
        </div>
        
        
    </body>
</html>  