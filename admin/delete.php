<?php
  // セッションの開始
  session_start();

  // ファイルの読み込み
  require_once('../inc/config.php');
  require_once('../inc/functions.php');

  // POSTかダイレクトかをチェック
  if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    // POSTじゃない場合
    header('Location: index.php');
    exit();
  }

  // CSFR対策 ・・・ トークンを確認
  check_token();

  try {
    // データベースへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'DELETE FROM posts WHERE id = ?';

    // ステートメント用意
    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をガッチャンコ
    $stmt->bindValue(1, (int)$_POST['id'] , PDO::PARAM_INT);

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
  <title>記事の削除</title>
</head>
<body>
  <h1>記事の削除</h1>
  <p>記事を削除しました。</p>

  <p><a href="./">一覧に戻る</a></p>
</body>
</html>
