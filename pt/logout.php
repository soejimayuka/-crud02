<?php
  // セッションの開始
  session_start();

  // セッションの初期化で、値を削除
  $_SESSION = array();

  // クッキーのセッションIDを削除
  setcookie(session_name(), '', time() - 3600);

  // セッションの破壊
  session_destroy();

  header('Location: ./');
  exit();
?>
