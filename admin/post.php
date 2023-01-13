<?php
  // セッションの開始
  session_start();


  // ファイルの読み込み
  require_once('../inc/config.php');
  require_once('../inc/functions.php');

    // CSRF対策 ・・・ トークンの生成
  set_token();

  try {
    // データベースへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

    // エラー発生時に「PDOException」という例外を投げる設定に変更
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'SELECT * FROM categories';

    // SQLクエリを実行
     $stmt = $dbh->query($sql);

    // 実行結果を連想配列として取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // print_r($result);
    // echo '<pre>';
;
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
  <title>投稿フォーム</title>
</head>
<body>
  <h1>投稿フォーム</h1>
  <!-- enctype属性は形式　multipart/form-dataをつけると添付されたファイルは$_FILESスーパーグローバル変数に格納される -->
<form action="add.php" method="post" enctype="multipart/form-data">
    <dl>
      <dt><label for="title">記事のタイトル</label></dt>
      <dd>
        <input type="text" id="title" name="title">
      </dd>
      <dt><label for="category_id">カテゴリーID</label></dt>
      <dd>
        <select name="category_id" id="category_id">
          <?php foreach($result as $row) : ?>
          <option value="<?php echo h($row['id']); ?>"><?php echo h($row['category_name']); ?></option>
          <?php endforeach; ?>
        </select>
      </dd>
      <dt><label for="content">記事の内容</label></dt>
      <dd>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
      </dd>
      <dt><label for="post_image">画像</label></dt>
      <dd>
        <input type="file" id="post_image" name="post_image">
      </dd>
    </dl>
    <p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
    <p><input type="submit" value="投稿"></p>
  </form>
</body>
</html>
