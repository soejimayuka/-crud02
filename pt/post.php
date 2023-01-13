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
    $sql = 'SELECT * FROM posts';

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
  <link rel="stylesheet" href="../css/common.css" />
</head>
<body>
  <p class="p-breadcrumbs_wrapper"><a href="mypage.php" class="p-breadcrumbs">マイページに戻る</a></p>
  <section class="l-section">
  <h2 class="c-heading -second">今日の体調を教えてください</h2>
<form action="add.php" method="post" class="p-post">
    <dl>
      <dd class="p-post_btn">
        <div class="p-post_btn -wrapper">
          <div class="p-post_btn -input">
            <input type="radio" id="cond" name="cond" value="とても良い">
          </div>
          <label for="verygood">とても良い</label>
        </div>
        <div class="p-post_btn -wrapper">
          <div class="p-post_btn -input">
            <input type="radio" id="cond" name="cond" value="良い">
          </div>
          <label for="good">良い</label>
        </div>
        <div class="p-post_btn -wrapper">
          <div class="p-post_btn -input">
            <input type="radio" id="cond" name="cond" value="いつもと変わらない">
          </div>
          <label for="so">いつもと変わらない</label>
        </div>
        <div class="p-post_btn -wrapper">
          <div class="p-post_btn -input">
            <input type="radio" id="cond" name="cond" value="悪い">
          </div>
          <label for="bad">悪い</label>
        </div>
        <div class="p-post_btn -wrapper">
          <div class="p-post_btn -input">
            <input type="radio" id="cond" name="cond" value="とても悪い">
          </div>
          <label for="sobad">とても悪い</label>
        </div>

      </dd>
      <h2 class="c-heading -second">今日の測定値を入力しましょう</h2>
      <dt><label for="temp">体温</label></dt>
      <dd class="p-post_input">
         <input type="number" id="temp" name="temp" step="0.1" min="35.0" max="40.0">
      </dd>

      <dt><label for="pulse">脈拍</label></dt>
      <dd class="p-post_input">
         <input type="number" id="pulse" name="pulse" step="1" min="30" max="115">
      </dd>

      <dt><label for="sbp">収縮期血圧</label></dt>
      <dd class="p-post_input">
         <input type="number" id="sbp" name="sbp" step="1" min="60" max="250">
      </dd>

      <dt><label for="dbp">拡張期血圧</label></dt>
      <dd class="p-post_input">
         <input type="number" id="dbp" name="dbp" step="1" min="30" max="150">
      </dd>
      <dt><label for="comment">メッセージ</label></dt>
      <dd class="p-post_input">
        <input type="text" id="comment" name="comment">
      </dd>
    </dl>
    <p><input type="hidden" name="user_id" value="1"></p>
    <p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
    <p class="l-btn d-spacer" data-y="min:smallTop min:smallBottom"><input type="submit" value="送信" class="c-button_secondary -btn_secondary"></p>
  </form>
  </section>
</body>
</html>
