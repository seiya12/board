<?php
// config・function読み込み
require_once '../../config.php';
require_once 'function.php';
$errmsg = '';
$cn = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($cn, 'utf8');
// 削除処理
if (!empty($_GET['del'])) {
  // del_flg更新
  delete_flag($cn, 't_post', $_GET['del']);
  header('location: index.php');
  exit;
}
// reply_id割り当て
if (empty($_GET['re'])) {
  $_GET['re'] = 0;
}
// post判定
if (!empty($_POST)) {
  // 投稿処理
  // エラーチェック
  if ($_POST['button'] == 'post') {
    if ($_POST['name'] == '') {
      $errmsg .= 'ニックネームを入力してください<br>';
    }
    if ($_POST['msg'] == '') {
      $errmsg .= 'メッセージを入力してください<br>';
    }
    if ($_POST['genre'] == '未選択') {
      $errmsg .= 'ジャンルを選択してください<br>';
    }
    if ($errmsg == '') {
      $idcnt = id_allotment($cn, 't_post');
      // 画像を移動
      if (!$_FILES['image']['name'] == '') {
        $uploade_file = $_FILES['image'];
        move_uploaded_file($uploade_file['tmp_name'], UPLOAD_PATH . $idcnt . '.jpg');
      }
      // データ登録
      $columns = ['id','name','msg','category','reply_id','del_flg','post_date'];
      $values = [$idcnt,$_POST['name'],$_POST['msg'],$_POST['genre'],$_POST['reply'],0,date('Y-m-d H:i:s')];
      insert_into($cn,'t_post',$columns,$values);
      header('location: index.php');
      exit;
    }
  }
}
// 出力処理
$sql = "SELECT id,name,msg,category,reply_id,post_date FROM t_post WHERE del_flg = 0 ";
if (!empty($_POST)) {
  if ($_POST['button'] == 'search' && $_POST['search'] != '未選択') {
    $sql .= "AND category = '" . $_POST['search'] . "' ";
  }
}
$sql .= "ORDER BY id desc;";
// 並び替え処理
$rows = output($cn, $sql);
// 掲示板読み込み
require_once 'tpl/index.php';
exit;
