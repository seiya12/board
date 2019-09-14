<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>評定課題掲示板</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
  <form action="index.php" method="post" autocomplete="off" enctype="multipart/form-data">
    <div id="formtable">
      <input type="hidden" name="reply" value=<?php echo $_GET['re']; ?>>
      <table>
        <tr>
          <th>ニックネーム</th>
          <td><input type="text" name="name"></td>
          <th>ジャンル</th>
          <td>
            <select name="genre">
              <option value="未選択" selected="selected">選択してください</option>
              <option value="映画">映画</option>
              <option value="本">本</option>
              <option value="音楽">音楽</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>メッセージ</th>
          <td colspan="3"><textarea name="msg" rows="3" cols="50"></textarea></td>
        </tr>
        <tr>
          <th>画像</th>
          <td colspan="3"><input type="file" name="image"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="1"><button type="submit" name="button" value="post">投稿</button></td>
          <td colspan="2"><span class="err"><?php echo $errmsg; ?></span></td>
        </tr>
      </table>
    </div>
    <table>
      <tr>
        <th>ジャンル選択</th>
        <td>
          <select name="search">
            <option value="未選択" selected="selected">選択してください</option>
            <option value="映画">映画</option>
            <option value="本">本</option>
            <option value="音楽">音楽</option>
          </select>
        </td>
        <td><button type="submit" name="button" value="search">検索</button></td>
      </tr>
    </table>
  </form>

<?php foreach ($rows as $row) : ?>
<div class="thread">
  <div class="msgbox">
    <div class="head">
      <p><?php echo $row['main']['id']; ?></p>
      <p>ニックネーム：<?php echo $row['main']['name']; ?></p>
      <p><?php echo $row['main']['category']; ?></p>
      <p><?php echo $row['main']['post_date']; ?></p>
      <span><a href="./index.php?re=<?php echo $row['main']['id']; ?>">[Re]</a></span>
      <p><a href="./index.php?del=<?php echo $row['main']['id']; ?>">[削除]</a></p>
    </div>
    <p class="msg"><?php echo $row['main']['msg']; ?></p>
<?php $file_path = UPLOAD_PATH . $row['main']['id'] . '.jpg'; ?>
    <span class='<?php echo file_exists($file_path) ? 'image' : ''; ?>'><img src=<?php echo file_exists($file_path) ? '"'.$file_path.'" alt="画像"' : '""'; ?>></span>
  </div>
  <?php if(isset($row['reply'])): ?>
    <?php foreach ($row['reply'] as $re_row) : ?>
      <div class="remsgbox">
        <div class="head">
          <p><?php echo $re_row['id']; ?></p>
          <p>ニックネーム：<?php echo $re_row['name']; ?></p>
          <p><?php echo $re_row['category']; ?></p>
          <p><?php echo $re_row['post_date']; ?></p>
          <p><a href="./index.php?del=<?php echo $re_row['id']; ?>">[削除]</a></p>
        </div>
        <p class="msg"><?php echo $re_row['msg']; ?></p>
<?php $file_path = UPLOAD_PATH . $re_row['id'] . '.jpg'; ?>
        <span class='<?php echo file_exists($file_path) ? 'image' : ''; ?>'>
          <img src=<?php echo file_exists($file_path) ? '"'.$file_path.'" alt="画像"' : '""'; ?>>
        </span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<?php endforeach; ?>
</body>
</html>