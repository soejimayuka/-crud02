<?php
  // セッションの開始
  session_start();

  // ログインユーザーを変数で管理
  $faname = 'fadummy'; // お好きなユーザー名に変更
  $fapassword = 'fadummy'; // お好きなパスワードに変更

  // ログインに成功したらセッションに保存
  if ( $_POST['faname'] == $faname && $_POST['fapassword'] == $fapassword  ) {

    // セッションにユーザ名を格納
    $_SESSION['faname'] = $_POST['faname'];

    $msg = 'ログインできました。下記よりマイページに移動しましょう。' ;

  } else {
    // ログイン失敗
    header('Location: ./');
    // $msg = 'ログイン出来ませんでした。';
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン完了：家族さま</title>
  <link rel="stylesheet" href="../css/common.css" />
</head>
<body>
  <section class="l-section">
  <h1 class="c-heading">ログイン完了</h1>

  <p class="u-center d-spacer" data-y="min:smallBottom"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>

  <ul>
    <li class="l-btn_secondary">
      <a href="mypage.php" class="c-button_secondary -btn_secondary">マイページ</a>
    </li>
    <li class="l-btn_secondary">
      <a href="./" class="c-button_secondary -btn_secondary">ログイン画面に戻る</a>
    </li>
  </ul>
  </section>
</body>
</html>
