<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン：家族さま</title>
  <link rel="stylesheet" href="../css/common.css" />
</head>
<body>
  <section class="l-section">
    <h1 class="c-heading">ログイン</h1>

    <form action="receive.php" method="post" class="p-login">
      <dl>
        <dt><label for="faname">名前</label></dt>
        <dd>
          <input type="text" name="faname" id="faname">
        </dd>
        <dt><label for="fapassword">パスワード</label></dt>
        <dd>
          <input type="password" name="fapassword" id="fapassword">
        </dd>
      </dl>
      <p class="l-btn"><input type="submit" value="ログイン" class="c-button -btn"></p>

    </form>
  </section>
</body>
</html>
