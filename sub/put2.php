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
        footer {
            width: 100%;
            height: 20px; 
            text-align: center;
            padding: 50px 0;
        }
        .r {
                background-color: #EEEEEE;
        }
        .b {
            border: none
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
        <br>
    <!--検索結果-->
    <?php 
    //ORかANDのif文　
    if(isset($_POST["search"])) {
        $errorMessage = "";
        if(empty($_POST["textbox"])) {
            $errorMessage = '未入力です。';
        } else {
        // 全角スペースも考慮して検索語を取得し、半角スペースに変換する
            $textbox = mb_convert_kana($_POST["textbox"], 's');
            $keywords = preg_split('/[\s,]+/', $textbox);
            $search_terms = array();
            $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
            if (mysqli_connect_errno()) {
                die("データベースに接続できません:" . mysqli_connect_error() . "\n");
            }
            mysqli_select_db($link, "okinawa_board");
        //複数のワードを取り出すためにループ
            foreach ($keywords as $keyword) {
                $words = mysqli_real_escape_string($link, $keyword);
                //$search_terms[] = "(boards.name LIKE '%$words%' OR boards.subject LIKE '%$words%' OR boards.message LIKE '%$words%' OR replies.name LIKE '%$words%' OR replies.subject LIKE '%$words%' OR replies.message LIKE '%$words%')";
                $search_terms[] = "(boards.name LIKE '%$words%' OR boards.subject LIKE '%$words%' OR boards.message LIKE '%$words%')";
                //複数条件を保持、後に記述のクエリのため
            }
            //OR replies.name LIKE '%$words%' OR replies.subject LIKE '%$words%' OR replies.message LIKE '%$words%'

        // OR,ANDの選択で検索条件を作る
            $operator = $_POST['or_and'] ?? 'OR'; //??=null合体演算子、デフォルトのOR
            if ($operator !== 'AND') { //ANDの場合、全てANDで結合できる
                $operator = 'OR';
            }

        // $search_terms を文字列に連結する、配列の要素を区切った文字で繋げる
        $search_condition = implode(" $operator ", $search_terms);
            /*$operatorがANDの場合
            (boards.name LIKE '%keyword1%' OR boards.subject LIKE '%keyword1%' OR boards.message LIKE '%keyword1%')
            AND
            (boards.name LIKE '%keyword2%' OR boards.subject LIKE '%keyword2%' OR boards.message LIKE '%keyword2%')
            */
        // クエリを実行する
        // 1. join suru
        // 2. where tsukeru
        // 3. whereni replies
        //$query = "SELECT * FROM boards JOIN replies ON boards.id = replies.board_id WHERE $search_condition";
        $query = "SELECT * FROM boards WHERE $search_condition";
        //echo $query;

        $result = mysqli_query($link, $query);
        if (!$result) {
            die("クエリの実行に失敗しました:" . mysqli_error($link));
        }            
            
            while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class='r'>
            <?php
            echo '<font color="red">' . $row['subject'] . '</font>';
            echo "-";
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
            
            ?><p align="right">
                <font color="#800000">
                <?php echo date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp)."<br>" ?>
                </font>
            </p> <?php ; 
            echo '<span style="color: ' . htmlspecialchars($row['color']) . ';">' . ($row['message']) . '</span>'. "<br>";
            if (!empty($row["image_path"])) {
                ?><a href="<?php echo htmlspecialchars($row["image_path"]); ?>" target="_blank">
                <?php
                echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="画像表示不可">';
            }
            ?></a>
            <br>
    </form>
            <div align="right" class="b">
            <form action="./reply.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                <button type="submit" name="reply">返信</button>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            </form>
            <form action="./delete_edit.php" method="POST" enctype="multipart/form-data" style="display: inline;">
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
        mysqli_close($link);
        }
    }
    ?>
    <footer>
        <hr noshade>
        <p>© RinoOkamoto 2024</p>
    </footer>
</body>
</html>