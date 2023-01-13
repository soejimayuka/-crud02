<?php

  // セッションの開始
  session_start();



  // ファイルの読み込み
  require_once('../inc/config.php'); //設定ファイル
  require_once('../inc/functions.php'); //独自関数ファイル


  // // GETパラメータのチェック
  // if ( !isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
  //   // $_GET['id'] が 存在していない、または空、または数値ではないときの場合
  //   header('Location: index.php');
  //   exit();
  // }

  // CSRF対策 ・・・ トークンの生成
  set_token();

// chat_app
  try {
    // データベースへ接続
    $dbh_chat = new PDO(DSN_chat, DB_USER_chat, DB_PASSWORD_chat);

     // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh_chat->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
   $sql_chat = 'SELECT * FROM posts WHERE id = ?';

    // ステートメント用意　?は後から変数を埋め込むマークだと知らせる
    $stmt_chat = $dbh_chat->prepare($sql_chat);

    // プレースホルダーに値をガッチャンコ
    $stmt_chat->bindValue(1, (int)$_GET['id'] , PDO::PARAM_INT);

    // ステートメントを実行　ガッチャンコしたときはexecuteで実行する　queryメソッドはできない
    $stmt_chat->execute();

    // 実行結果を連想配列として取得　fetchとfetchAllがある 1件なのでfetchでOK
    $result_chat = $stmt_chat->fetch(PDO::FETCH_ASSOC);
    echo '<pre>';
    print_r($result_chat);
    echo '<pre>';

    // データベースとの接続を終了
    $dbh_chat = null;

  } catch (PDOException $e) {
    //　例外発生時の処理
    echo 'エラー' . h($e->getMessage());
    exit();
  }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FA:メッセージ編集</title>
  <link rel="stylesheet" href="../css/common.css" />
</head>
<body>
    <section class="l-section">
  <h1 class="c-heading">メッセージの編集</h1>



 <form action="update_chat.php" method="post" enctype="multipart/form-data">
    <dl>

      <dt><label for="txt">メッセージの変更</label></dt>
      <dd>
        <textarea name="txt" id="txt" cols="30" rows="10"><?php echo h($result_chat["txt"]); ?></textarea>
      </dd>
    <p><input type="hidden" name="id" value="<?php echo h($result_chat['id']); ?>"></p>
    <p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
    <p><input type="submit" value="変更"></p>
  </form>
    </section>
</body>
</html>
