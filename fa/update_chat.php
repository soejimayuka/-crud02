<?php
  // セッションの開始
  session_start();

  // ファイルの読み込み
  require_once('../inc/config.php');
  require_once('../inc/functions.php');

  // 投稿ボタンが押されたかをチェック
  if ( $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // ダイレクトでアクセスされた時
    header('Location: index.php');
    exit();
  }

  // CSRF対策 ・・・ トークンのチェック
  check_token();


  try {
    // データベースへ接続
    $dbh_chat = new PDO(DSN_chat, DB_USER_chat, DB_PASSWORD_chat);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh_chat->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成 記事IDと一致するレコードを更新する
    $sql_chat = 'UPDATE posts SET txt=? WHERE id = ?';

    // ステートメント用意
    $stmt_chat = $dbh_chat->prepare($sql_chat);

    // プレースホルダーに値をガッチャンコ
    $stmt_chat->bindValue(1, $_POST['txt'] , PDO::PARAM_STR);
    $stmt_chat->bindValue(2, (int)$_POST['id'] , PDO::PARAM_INT);

    // ステートメントを実行
    $stmt_chat->execute();

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
  <title>記事の更新</title>
</head>
<body>
  <h1>記事の更新</h1>
  <p>記事を更新しました。</p>

  <p><a href="./">一覧に戻る</a></p>
</body>
</html>
