<?php
  // セッションの開始
  session_start();

  // ファイルの読み込み
  require_once('../inc/config.php'); //設定ファイル
  require_once('../inc/functions.php'); //独自関数ファイル

  // CSRF対策 ・・・ トークンの生成
  set_token();

  try {
    // データベースへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'SELECT * FROM posts';

    // SQLを実行
    $stmt = $dbh->query($sql);

    // 実行結果を連想配列として取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // print_r($result);
    // echo '<pre>';

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
  <title>管理画面</title>
</head>
<body>
  <h1>管理画面</h1>
  <p><a href="post.php">新しい記事を投稿する</a></p>
  <table border="1">
    <thead>
      <tr>
        <th>ID</th>
        <th>タイトル</th>
        <th>公開日</th>
        <th>更新日</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($result as $row) : ?>
      <tr>
        <td><?php echo h($row['id']); ?></td>
        <td><?php echo h($row['title']); ?></td>
        <td><time datetime="<?php echo h($row['created']); ?>"><?php echo h(date('Y年m月d日', strtotime($row['created']))); ?></time></td>
        <td><time datetime="<?php echo h($row['modified']); ?>"><?php echo h(date('Y年m月d日', strtotime($row['modified']))); ?></time></td>
      <td><a href="edit.php?id=<?php echo h($row['id']); ?>">編集</a></td>
      <td>
      <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo h($row['id']); ?>">
        <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
        <input type="submit" value="削除">
      </form>
      </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
