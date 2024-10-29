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
          <footer>
               <hr noshade>
               <p>© RinoOkamoto 2024</p>
          </footer>
    </body>
</html>  
