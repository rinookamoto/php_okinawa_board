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
        .rep {
            background-color: #EEEEEE;
        }
        .b {
                border: none;
            }
        .b form {
            display: inline; /* ボタンをインライン表示にする */
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
        <hr>
        <a href="./insert.php">一覧（新規投稿）</a> |
        <a href="./how_to_use.php">使い方</a> |
        <a href="mailto:?body=http://localhost:8080/insert.php">携帯へURLを送る</a> |
        <a href="./search.php">ワード検索</a>
        <hr>
    </header>
    <form action="./search_result.php" method="POST" enctype="multipart/form-data">
        <p align="center"><a href="./insert.php">掲示板へ戻る</a></p>
        <p align="center">検索語を入力して下さい。</p>
        <div>
            <p>
                検索語:
                <input type="text" name="textbox" value="" size="30">
                <input type="radio" name="or_and" value="OR" checked>OR
                <input type="radio" name="or_and" value="AND">AND
            </p>
            <p align="center"><input type="submit" name="search" value="検索開始"></p>
        </div>
    </form>
    <br>

    <!--検索結果　投稿オリジナル-->
    <?php 
        $errorMessage = "";
        if(empty($_POST["textbox"])) {
            $errorMessage = '未入力です。';
        } else {
            // データベース接続
            $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
            if (mysqli_connect_errno()) {
                die("データベースに接続できません:" . mysqli_connect_error() . "\n");
            }

            // SQLインジェクション対策として、エスケープ処理
            $textbox = mb_convert_kana($_POST["textbox"], 's');
            $keywords = preg_split('/[\s,]+/', $textbox);

            $queryParts = [];
            foreach ($keywords as $keyword) {
                $queryParts[] = "(b.name LIKE '%$keyword%' OR b.subject LIKE '%$keyword%' OR b.message LIKE '%$keyword%' OR r.name LIKE '%$keyword%' OR r.subject LIKE '%$keyword%' OR r.message LIKE '%$keyword%')";
            }

            // AND, OR の選択で検索条件を作る
            $operator = $_POST['or_and'] ?? 'OR';
            if ($operator !== 'AND') {
                $operator = 'OR';
            }

            $search_condition = implode(" $operator ", $queryParts);

            $query = "SELECT * FROM boards b LEFT JOIN replies r ON b.id = r.board_id WHERE $search_condition";
            echo $query;
            $result = mysqli_query($link, $query);
            if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
            }
            $rep_query = "SELECT * FROM boards b RIGHT JOIN replies r ON b.id = r.board_id WHERE $search_condition";
            $result_re = mysqli_query($link, $rep_query);
            if (!$result_re) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="rep">
                    <?php
                    echo htmlspecialchars($row["subject"]) . " - ";
                    echo '<a href="mailto:' . htmlspecialchars($row["email"]) . '">' . htmlspecialchars($row["name"]) . '</a>&nbsp;';
                    if (!empty($row["url"])) {
                        echo '<a href="' . htmlspecialchars($row["url"]) . '">URL</a><br>';
                    }
                    date_default_timezone_set('Asia/Tokyo');
                    $week = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
                    echo date("Y/m/d (D) H:i:s", strtotime($row["create_at"])) . "<br>";
                    echo '<span style="color: ' . htmlspecialchars($row['color']) . ';">' . nl2br(htmlspecialchars($row['message'])) . '</span><br>';
                    if (!empty($row["image_path"])) {
                        ?>
                        <a href="<?php echo htmlspecialchars($row["image_path"]); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($row["image_path"]); ?>" alt="画像表示不可">
                        </a><br>
                        <?php
                    }
                    ?>
                    <div align="right" class="b">
                        <form action="./reply.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                            <button type="submit" name="reply">返信</button>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        </form>
                        <form action="./delete_edit.php" method="POST" enctype="multipart/form-data">
                            <button type="submit" name="delete" value="delete">削除</button>
                            <button type="submit" name="edit" value="edit">編集</button>
                            <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($row['delete_key']); ?>">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        </form>
                    </div>
                </div>
                <br>
                <?php
            }

            // 検索結果　返信
            
            while ($replies = mysqli_fetch_assoc($result_re)) {
                ?>
                <div class="rep">
                    <font color="red"><?php echo htmlspecialchars($replies["subject"]); ?></font>
                    <?php echo " - "; ?>
                    <a href="mailto:<?php echo htmlspecialchars($replies["email"]); ?>"><?php echo htmlspecialchars($replies["name"]); ?></a>&nbsp;
                    <?php
                    if (!empty($replies["url"])) {
                        echo '<a href="' . htmlspecialchars($replies["url"]) . '">URL</a><br>';
                    }
                    echo date("Y/m/d (D) H:i:s", strtotime($replies["create_at"])) . "<br>";
                    echo '<span style="color: ' . htmlspecialchars($replies['color']) . ';">' . nl2br(htmlspecialchars($replies['message'])) . '</span><br>';
                    if (!empty($replies["image_path"])) {
                        ?>
                        <a href="<?php echo htmlspecialchars($replies["image_path"]); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($replies["image_path"]); ?>" alt="画像表示不可">
                        </a><br>
                        <?php
                    }
                    ?>
                    <p align="right" class="b">
                        <form action="./reply_key.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                            <button type="submit" name="delete" value="delete">削除</button>
                            <button type="submit" name="edit" value="edit">編集</button>
                            <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($replies['delete_key']); ?>">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($replies['id']); ?>">
                        </form>
                    </p>
                </div>
                <br>
                <?php
            }
        }
    ?>
    <footer>
        <hr>
        <p>© RinoOkamoto 2024</p>
    </footer>
</body>
</html>