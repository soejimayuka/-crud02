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
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
   $sql = 'INSERT INTO posts (cond, temp, pulse, sbp, dbp, comment, user_id, created) VALUES(?, ?, ?, ?, ?, ?, ?, now())';


    // ステートメント用意
    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をガッチャンコ
    $stmt->bindValue(1, $_POST['cond'], PDO::PARAM_STR);
    $stmt->bindValue(2, (int)$_POST['temp'], PDO::PARAM_INT);
    $stmt->bindValue(3, (int)$_POST['pulse'], PDO::PARAM_INT);
    $stmt->bindValue(4, (int)$_POST['sbp'], PDO::PARAM_INT);
    $stmt->bindValue(5, (int)$_POST['dbp'], PDO::PARAM_INT);
    $stmt->bindValue(6, $_POST['comment'], PDO::PARAM_STR);
    $stmt->bindValue(7, (int)$_POST['user_id'], PDO::PARAM_INT);

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
  <p>本日の体調を登録しました。</p>
  <p><a href="mypage.php">マイページに戻る</a></p>
</body>
</html>
