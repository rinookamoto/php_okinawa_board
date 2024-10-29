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
    $errorMessage = "";
    if(isset($_POST["search"])) {
        if(empty($_POST["textbox"])) {
            $errorMessage = '未入力です。';
        }
        if(!empty($_POST["textbox"])) {
            $textbox = $_POST["textbox"];
            $textboxs = explode(" ", mb_convert_kana($textbox, 's'));
            
            $link = mysqli_connect("mysql_db","root", "root","okinawa_board");
            if (mysqli_connect_errno()) {
                die("データベースに接続できません:" . mysqli_connect_error() . "\n");
            } 
            //PDO以外のやり方では上記必要

            //$sql = "ALTER TABLE boards ADD FULLTEXT(name, subject, color, message, image_path, email, url, delete_key, create_at) WITH PARSER ngram;";
            //$sql = "ALTER TABLE replies ADD FULLTEXT(name, subject, color, message, image_path, email, url, delete_key, create_at) WITH PARSER ngram;";
            /*$result = mysqli_query($link, $sql);
            if (!$result) {
                die("FULLTEXTインデックスの設定に失敗しました:" . mysqli_error($link));
            }
    */
            $search = mysqli_real_escape_string($link, $textbox);
            
    //試し６ UNION
    /*$query = "(SELECT id, name, subject, color, message, image_path, email, url, delete_key,create_at FROM boards WHERE MATCH(name, subject, color, message, image_path, email, url, delete_key) AGAINST('$search' IN BOOLEAN MODE)) 
    UNION 
    (SELECT id, name, subject, color, message, image_path, email, url, delete_key,create_at FROM replies WHERE MATCH(name, subject, color, message, image_path, email, url, delete_key) AGAINST('$search' IN BOOLEAN MODE))";
    $result = mysqli_query($link, $query);
            if (!$result) {
            die("クエリの実行に失敗しました:" . mysqli_error($link));
            }
*/
/*
    //試し５
// (2)データベースと接続
$mysqli = new mysqli( 'mysql_db', 'root', 'root', 'okinawa_board');

if( $mysqli->connect_errno ) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

// (3)文字コードを設定
$mysqli->set_charset('utf8');

// (4)プリペアドステートメントを使ってデータを取得
$stmt = $mysqli->prepare('SELECT * FROM boards WHERE id = ?');

// (5)検索するIDをセット
$stmt->bind_param('i', $id);

// (6)検索を実行
$stmt->execute();

// (7)結果を取得
$result = $stmt->get_result();

// (8)結果を出力
while( $row_data = $result->fetch_array(MYSQLI_ASSOC) ) {
	var_dump($row_data);
}
*/
/*
    //試し３
    $dbh = new PDO('mysql:host=mysql_db;dbname=okinawa_board', 'root', 'root');
    
    // SQLクエリの修正とprepareメソッドの使用
    $stmt = $dbh->prepare('SELECT * FROM boards WHERE name LIKE :name OR subject LIKE :subject OR message LIKE :message');
    
    $search = "%search_term%";
    $stmt->bindValue(':name', $search, PDO::PARAM_STR);
    $stmt->bindValue(':subject', $search, PDO::PARAM_STR);
    $stmt->bindValue(':message', $search, PDO::PARAM_STR);
    
    // executeメソッドでクエリを実行する
    $stmt->execute();
    
    // 結果をfetchメソッドで取得する
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    print_r($result); // 結果を出力する
*/
     /*   //試し２ JOIN LIKE
    $query = "SELECT *
            FROM boards b
            JOIN replies r 
            ON b.id = r.board_id
            WHERE b.name LIKE '%$search%'
                OR b.subject LIKE '%$search%'
                OR b.message LIKE '%$search%'
                OR r.name LIKE '%$search%'
                OR r.subject LIKE '%$search%'
                OR r.message LIKE '%$search%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("クエリの実行に失敗しました:" . mysqli_error($link));
    }
     */
    /* 試し１
    //match()のINNER JOIN
            $query = "SELECT 
                        *
                    FROM 
                        boards b
                    JOIN 
                        replies r
                    ON 
                        b.id = r.board_id
                    WHERE
                        MATCH(b.name, b.subject, b.message) AGAINST('$search' IN BOOLEAN MODE)
                        OR MATCH(r.name, r.subject, r.message) AGAINST('$search' IN BOOLEAN MODE)";
            $result = mysqli_query($link, $query);
            if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
            }
   */              

    //ORかANDのif文　試し０
    if(isset($_POST['or_and']) && $_POST['or_and'] == 'OR'){
        echo "or";

        //これに返信を含めたらOK 
        $query = "SELECT * FROM boards WHERE boards.name LIKE '%$search%' OR boards.name LIKE '%$search%' OR boards.subject LIKE '%$search%' OR boards.subject LIKE '%$search%' OR boards.message LIKE '%$search%' OR boards.message LIKE '%$search%'";
        $result = mysqli_query($link, $query);
                if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
                }
    
        /*$query = "SELECT * FROM boards WHERE MATCH(name, subject, message) AGAINST('$search' IN BOOLEAN MODE)";
            $result = mysqli_query($link, $query);
            if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
            }
            */
    } else {
        echo 'and';
        $query = "SELECT *
        FROM boards b
        WHERE (b.name LIKE '%$search%' AND b.name LIKE '%$search%')
           OR (b.subject LIKE '%$search%' AND b.subject LIKE '%$search%')
           OR (b.message LIKE '%$search%' AND b.message LIKE '%$search%')";
        $result = mysqli_query($link, $query);
                if (!$result) {
                die("クエリの実行に失敗しました:" . mysqli_error($link));
                }
    
       /* $query = "SELECT * FROM boards WHERE MATCH(name, subject, message) AGAINST('+$search +$search' IN BOOLEAN MODE)";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("クエリの実行に失敗しました:" . mysqli_error($link));
        }
        */
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
                <button type="submit" name="reply">全て表示する</button>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            </form>
        <!--もし返信内容だったら-->
    <?php
        if($row['id']){
    ?>
            <form action="./reply_key.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                <button type="submit" name="delete" value="delete">削除</button>
                <button type="submit" name="edit" value="edit">編集</button>
                <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($row['delete_key']); ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
     <?php
            } else {
        ?>
            <form action="./delete_edit.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                <button type="submit" name="delete" value="delete">削除</button>
                <button type="submit" name="edit" value="edit">編集</button>
                <input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($row['delete_key']); ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            </form>
    <?php    } ?>
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
