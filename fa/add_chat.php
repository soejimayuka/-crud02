<?php
  // セッションの開始
  session_start();

  // ファイルの読み込み
  require_once('../inc/config.php');
  require_once('../inc/functions.php');

  // 投稿ボタンが押されたかをチェック
  if ( $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // ダイレクトでアクセスされた時
    header('Location: post.php');
    exit();
  }

  // CSRF対策 ・・・ トークンのチェック
  check_token();

  try {
    // データベースへ接続
    $dbh = new PDO(DSN_chat, DB_USER_chat, DB_PASSWORD_chat);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'INSERT INTO posts (person, txt, created) VALUES(?, ?, now())';

    // ステートメント用意
    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をガッチャンコ
    $stmt->bindValue(1, $_POST['person'], PDO::PARAM_STR);
    $stmt->bindValue(2, $_POST['txt'], PDO::PARAM_STR);

    // ステートメントを実行
    $stmt->execute();


    // データベースとの接続を終了
    $dbh = null;

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
  <title>登録完了</title>
</head>
<body>
  <h1>登録完了</h1>
  <p>新着情報を登録しました。</p>
</body>
</html>
