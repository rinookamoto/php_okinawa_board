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
               background-color: #EEEEEE;
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
    <a href="./how_to_use.php"><font color="#800080">使い方</font></a> 
    <hr size="1" width="80%" noshade>
    </header> 
    <div>
        <p><font color="red">はじめに</font></p>
        <ul>
          <li>この掲示板は、文章/画像を投稿することができます。</li>
        </ul>
        <p><font color="red">投稿について</font></p>  
        <ul>
          <li>お名前、件名、メッセージ、メールアドレス、編集/削除キーは必須入力です。</li>
          <li>HTMLタグは使用できません。</li>
          <li>メッセージないのURLは自動リンクします。</li>
          <li>半角カナの仕様もOKです。</li>
        </ul>
        <p><font color="red">ワード検索について</font></p>  
        <ul>
        <li>検索したい単語を入力すると、その単語にマッチした記事を表示します。返信内容は検索できません。</li>
        </ul>
        <p><font color="red">削除・編集について</font></p>    
        <ul>
        <li>投稿時にパスワードを設定した記事を削除・編集することができます。</li>
        <li>トピック（親）記事を削除しようとすると、すでに返信がついている場合、返信も含めて全て削除されます。</li>
        </ul>
     </div>
    <footer>
          <hr noshade>
          <p>© RinoOkamoto 2024</p>
     </footer>

    </body>
</html>  
