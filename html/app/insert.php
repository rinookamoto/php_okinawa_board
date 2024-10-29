<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="utf-8">
        <title>沖縄掲示板</title>
        <style>
            header {
                text-align: center;
            }
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
            .b {
                border: none
            }
            .reply {
                margin-right: -30px;
                border-right: none;
                border-left: none;
                border-bottom: none;
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
        <header>
        <h1>掲示板 Sample</h1>
        <hr size="1" width="80%" noshade>
        <a href="./insert.php"><font color="#800080">一覧（新規投稿）</font></a>
        |
        <a href="./how_to_use.php"><font color="#800080">使い方</font></a>
        |
        <a href="mailto:?body=http://localhost:8080/insert.php"><font color="#800080">携帯へURLを送る</font></a>
        |
        <a href="./search.php"><font color="#800080">ワード検索</font></a>
        <hr size="1" width="80%" noshade>
        </header>
        <!--入力欄-->
        <form action="./preview.php" method="POST" enctype="multipart/form-data">
        <div>
            <table>
                <tr>
                    <th align="left"><label for="name">名前</label></th>
                    <td><input type="text" name="name" value="" size="20" required></td>
                </tr>
                <tr>
                    <th align="left"><label for="subject">件名</label></th>
                    <td><input type="text" name="subject" value="" size="30"></td>
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
                    <td>
                        <input type="password" name="delete_key" value="" size="10" 
                        pattern="[0-9A-Za-z]{4,8}" maxlength="8" required>
                        <label for="delete_key"><small>(半角英数字のみで4〜8文字)</small></label>
                    </td>
                </tr>
                <tr>
                    <th colspan="2"><input type="checkbox" name="preview" value="1">
                    プレビューする<small>（投稿前に、内容をプレビューして確認できます）</small></th>
                </tr>
                <tr>
                    <?php 
                        //プレビュー画面へのため
                        $target = "preview.php";
                    ?>
                    <td colspan="2" align="center"><input type="submit" value="投稿" onClick="link($target)">
                    <input type="reset" value="リセット"></td>
                </tr>
            </table>
        </div>
        </form>
        <br>
        <br>
        <?php
        //投稿内容
        define('MAX','10');
        //データベース接続
        $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
        if (mysqli_connect_errno()) {
            die("データベースに接続できません:" . mysqli_connect_error() . "\n");
        } 
        mysqli_select_db($link,"okinawa_board");
        //ページナビゲーション用
        $count_sql = 'SELECT COUNT(*) as cnt FROM boards';
        $count_result = mysqli_query($link, $count_sql);
        if ($count_result) {
            $count_row = mysqli_fetch_assoc($count_result);
            $total_count = $count_row['cnt'];
            $max_page = ceil($total_count / MAX); // 総ページ数の計算
        } else {
            die("クエリの実行に失敗しました：" . mysqli_error($link));
        }
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * MAX;
        $query = "SELECT * FROM boards ORDER BY id DESC LIMIT " . MAX . " OFFSET " . $offset;
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("クエリの実行に失敗しました：" . mysqli_error($link));
        }
        
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class='r'>
                <?php
                echo '<font color="red">' . $row["subject"] . '</font>';
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
                $timestamp = strtotime($create_at); //日付や時刻の文字列を Unix タイムスタンプに変える
                $delete_key = $row["delete_key"];
                $id = $row["id"];
                ?>
                <p align="right">
                    <font color="#800000">
                    <?php echo date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp)."<br>"; ?>
                    </font>
                </p> 
                <?php 
                echo '<span style="color: ' . htmlspecialchars($row['color']) . ';">' . nl2br($row['message']) . '</span>'. "<br>";
                if (!empty($row["image_path"])) {
                    ?><a href="<?php echo htmlspecialchars($row["image_path"]); ?>" target="_blank">
                    <?php
                    echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="画像表示不可">';
                }
                    ?></a>
                <br>            
                <div align="right" class="b">
                    <form action="./reply.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                        <button type="submit" name="reply">返信</button>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    </form>
                    <form action="./delete_edit.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                        <button type="submit" name="delete" value="delete">削除</button>
                        <button type="submit" name="edit" value="edit">編集</button>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    </form>
            </div>

        <?php 
        //返信内容
                $replies = $row['id'];
                $query_re = "SELECT * FROM replies WHERE board_id = $replies"; //replies id = board＿id
                $result_re = mysqli_query($link, $query_re);
                if (!$result_re) {
                    die("クエリの実行に失敗しました：" . mysqli_error($link));
                }

                while($replies = mysqli_fetch_assoc($result_re)) {
        ?>
                <div class="reply"></div>
                <?php
                echo '<font color="red">' . $replies["subject"] .'</font color>';
                echo " - ";
                echo '<a href="mailto:' . htmlspecialchars($replies["email"]) . '">' . htmlspecialchars($replies["name"]) . '</a>';
                echo '&nbsp';
                if (!empty($replies["url"])){
                    echo '<a href="' . htmlspecialchars($replies["url"]) . '">URL</a>'."<br>";
                }
                date_default_timezone_set('Asia/Tokyo');    
                $week = array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
                $date = "Y/m/d (";
                $time = ") H:i:s";
                $create_at = $replies["create_at"];
                $timestamp = strtotime($create_at);
                $delete_key = $replies["delete_key"];
                $id = $replies["id"];
                ?><p align="right">
                    <font color="#800000">
                    <?php echo date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp)."<br>" ?>
                    </font>
                </p> <?php ;
                echo '<span style="color: ' . htmlspecialchars($replies['color']) . ';">' . nl2br($replies['message']) . '</span>'. "<br>";
                if (!empty($replies["image_path"])) {
                    ?><a href="<?php echo htmlspecialchars($replies["image_path"]); ?>" target="_blank">
                    <?php
                    echo '<img src="' . htmlspecialchars($replies["image_path"]) . '" alt="画像表示不可">';
                }
                ?></a><?php
                echo "<br>";            
                ?>
                <div align="right" class="b">
                <form action="./reply_key.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                        <button type="submit" name="delete" value="delete">削除</button>
                        <button type="submit" name="edit" value="edit">編集</button>
                        <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($replies['delete_key']); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($replies['id']); ?>">
                </form>
            </div>
            <br>
            <?php
        }       
        ?> </div></div><br> <?php               
    }
//} //whileより外
        mysqli_close($link);
        ?>        
          
<!--ページナビゲーションの表示-->
        <p align="center">
        <?php 
        if ($page >= 2){ ?>
            <a href="insert.php?page=<?php echo($page - 1); ?>">＜＜前へ</a>
        <?php } ?>

        <?php if($page < $max_page) { ?>
            <a href="insert.php?page=<?php echo($page + 1); ?>">次へ＞＞</a>

        <?php } ?>
        </p>

        <footer>
        <hr noshade>
        <p>© RinoOkamoto 2024</p>
        </footer>

    </body>
</html>  
