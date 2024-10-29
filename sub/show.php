<!DOCTYPE html>
<html lang="jp"  dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
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
     
      ?>
     <table border="1">
    <tr>
        <td>名前</td>
        <td>件名</td>
        <td>メッセージ</td>
        <td>画像</td>
        <td>メールアドレス</td>
        <td>url</td>
        <td>文字色</td>
        <td>削除キー</td>
        <td>作成時間</td>
    </tr>
     <?php   
        $result = mysqli_query($link, "select * from boards;");
        while ($row = mysqli_fetch_assoc($result)) {    
            echo "<tr>";
            echo "<td>" . $row["name"]. "</td>";
            echo "<td>" . $row["subject"]. "</td>";
            echo "<td>" . $row["message"]. "</td>";
            echo "<td>" . $row["image_path"]. "</td>";
            echo "<td>" . $row["email"]. "</td>";
            echo "<td>" . $row["url"]. "</td>";
            echo "<td>" . $row["color"]. "</td>";
            echo "<td>" . $row["delete_key"]. "</td>";
            date_default_timezone_set('Asia/Tokyo');    
            $week = array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
            $date = "Y/m/d (";
            $time = ") H:i:s";
            $create_at = $row["create_at"];
            //$timestamp = strtotime($create_at);
            //echo "<td>" . date($date, $timestamp).$week[date('w', $timestamp)].date($time, $timestamp) . "</td>";
            echo "<td>" .date($date).$week[date('w')].date($time) . "</td>";

            echo "</tr>"; 
        }

        mysqli_free_result($result);
        ?>
        </table>  
    </body>
</html>


