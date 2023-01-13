<?php

  // セッションの開始
  session_start();

  // ログインチェック
  if ( !isset($_SESSION['faname']) || empty($_SESSION['faname']) ) {
    // ログインしていない

    // ログインフォームへリダイレクト
    header('Location: ./');
    exit();
  }

  // ファイルの読み込み
  require_once('../inc/config.php'); //設定ファイル
  require_once('../inc/functions.php'); //独自関数ファイル

  try {
    // データベースへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'SELECT * FROM posts ORDER BY created DESC';

    // SQLを実行
    $stmt = $dbh->query($sql);

    // 実行結果を連想配列として取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // データベースとの接続を終了
    $dbh = null;

  } catch (PDOException $e) {
    //　例外発生時の処理
    echo 'エラー' . h($e->getMessage());
    exit();
  }


// chat_app
  try {
    // データベースへ接続
    $dbh_chat = new PDO(DSN_chat, DB_USER_chat, DB_PASSWORD_chat);

     // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh_chat->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
   $sql_chat = 'SELECT * FROM posts WHERE created = CURRENT_DATE';
  //  $sql = 'SELECT * FROM posts WHERE created = date(now())';


    // ステートメント用意　?は後から変数を埋め込むマークだと知らせる
    $stmt_chat = $dbh_chat->prepare($sql_chat);

    // SQLを実行
    $stmt_chat = $dbh_chat->query($sql_chat);

    // 実行結果を連想配列として取得　fetchとfetchAllがある 1件なのでfetchでOK
    $result_chat = $stmt_chat->fetch(PDO::FETCH_ASSOC);

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
  <title>FA:マイページ</title>
  <link rel="stylesheet" href="../css/common.css" />
</head>
<body>
    <section class="l-section">
  <h1 class="c-heading">家族の方：マイページ</h1>
    <p class="l-btn_secondary">
      <a href="detail.php" class="c-button_secondary -btn_secondary">今日の体調をみる</a>
    </p>
    <p class="l-btn_secondary">
      <a href="post_chat.php" class="c-button_secondary -btn_secondary">メッセージを送る</a>
    </p>
    <div class="p-icon_wrapper">
    <p class="p-icon"><img src="../img/icon.png" alt=""></p></div>


<div class="p-chat__wrapper">
  <?php
if (!empty($result_chat)) {
  echo h($result_chat['txt']);
  }else{
    echo h("");
  }
  ?>
</div>
    <div class="p-chatBtn__wrapper ">
      <p class="p-chatBtn__link"><a href="edit_chat.php?id=<?php echo h($result_chat['id']); ?>">編集する</a></p>
      <p class="p-chatBtn__link"><a href="edit_chat.php?id=<?php echo h($result_chat['id']); ?>">削除する</a></p>

</div>


    <p class="l-btn_secondary"><a href="logout.php" class="c-button_secondary -btn_secondary">ログアウト</a></p>
    </section>
</body>
</html>
