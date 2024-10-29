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
    <form action="./search_result.php" method="POST" enctype="multipart/form-data">
        <p align="center"><<a href="./insert.php">掲示板へ戻る</a>></p>
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
            $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
            if (mysqli_connect_errno()) {
                die("データベースに接続できません:" . mysqli_connect_error() . "\n");
            }

        // 全角スペースも考慮して検索語を取得し、半角スペースに変換する
            $textbox = mb_convert_kana($_POST["textbox"], 's');
            $keywords = preg_split('/[\s,]+/', $textbox);
            foreach ($keywords as $keyword) {
                $queryParts[] = "(b.name LIKE '%$keyword%' OR b.subject LIKE '%$keyword%' OR b.message LIKE '%$keyword%')";
            }
            // OR,ANDの選択で検索条件を作る
            $operator = $_POST['or_and'] ?? 'OR'; //??=null合体演算子、デフォルトのOR
            if ($operator !== 'AND') { //ANDの場合、全てANDで結合できる
                $operator = 'OR';
            }

            // $search_terms を文字列に連結する、配列の要素を区切った文字で繋げる
            $search_condition = implode(" $operator ", $queryParts);
            /*$operatorがANDの場合
            (boards.name LIKE '%keyword1%' OR boards.subject LIKE '%keyword1%' OR boards.message LIKE '%keyword1%')
            AND
            (boards.name LIKE '%keyword2%' OR boards.subject LIKE '%keyword2%' OR boards.message LIKE '%keyword2%')
            */
        
            $query = "SELECT * FROM boards b WHERE" . $search_condition;
            
            //$query = "SELECT * FROM boards JOIN replies ON boards.id = replies.board_id WHERE $search_condition";
            //$rep_query = "SELECT * FROM boards JOIN replies ON boards.id = replies.board_id WHERE $search_condition";
            $result = mysqli_query($link, $query);
            if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
            }  
         
            while ($row = mysqli_fetch_assoc($result)) {
                ?> <div class="rep">

                <?php
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
                    $delete_key = $row["delete_key"];
                    $id = $row["id"];
                ?>
                
                    <p align="right">
                        <font color="#800000">
                        <?php echo date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp)."<br>"; ?>
                        </font>
                    </p> 
                    <?php 
                    echo '<span style="color: ' . htmlspecialchars($row['color']) . ';">' . htmlspecialchars($row['message']) . '</span>'. "<br>";
                    if (!empty($row["image_path"])) {
                    ?>
                        <a href="<?php echo htmlspecialchars($row["image_path"]); ?>" target="_blank">
                    <?php
                        echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="画像表示不可">';
                    }
                    ?>
                        </a>
                        <br>   
                    <!--削除と編集のためのフォーム-->
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
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        </form>
                    </div>
            <?php
                    ?> 
                </div> 
                    <br>
                    <?php //rep

                } //while          
            //検索結果　返信
            ?>
                <?php 
                foreach ($keywords as $keyword) {
                    $query_Parts[] = "(r.name LIKE '%$keyword%' OR r.subject LIKE '%$keyword%' OR r.message LIKE '%$keyword%')";
                }
                // OR,ANDの選択で検索条件を作る
                $operators = $_POST['or_and'] ?? 'OR'; //??=null合体演算子、デフォルトのOR
                if ($operators !== 'AND') { //ANDの場合、全てANDで結合できる
                    $operators = 'OR';
                }
                $search_conditions = implode(" $operators ", $query_Parts);
                
                $rep_query = "SELECT *
                FROM replies r
                WHERE " . $search_conditions;
                $result_re = mysqli_query($link, $rep_query);
                if (!$result_re) {
                    die("クエリの実行に失敗しました:" . mysqli_error($link));
                }            
                while($replies = mysqli_fetch_assoc($result_re)) {
                    ?> <div class="rep"> <?php
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
                    <?php //rep(2)
                } //while rep 
        } //入力した場合のelse
    ?>
    <footer>
        <hr noshade>
        <p>© RinoOkamoto 2024</p>
    </footer>
</body>
</html>
