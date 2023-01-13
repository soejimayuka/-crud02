<?php
  // セッションの開始
  session_start();

  // ファイルの読み込み
  require_once('../inc/config.php');
  require_once('../inc/functions.php');

  // CSRF対策 ・・・ トークンの生成
  set_token();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿フォーム</title>
</head>
<body>
<form action="add_chat.php" method="post" name="form">

        <p>
          <input type="hidden" id="person" name="person" value="fam">
        </p>

        <p>メッセージ</p>
        <div>
          <textarea name="txt" id="txt"></textarea>
        </div>

        <p>
          <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
        </p>

        <p class="chat-submit">
          <input type="submit" value="投稿">
        </p>


</form>
</body>
</html>
