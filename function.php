<?php
  // 処理関数
  function output($cn,$sql){
    $result = mysqli_query($cn, $sql);
    mysqli_close($cn);
    $rows = [];
    $new_rows = [];
    //データ取り出し
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
    // reply並び替え
    foreach($rows as $row){
      $row['msg'] = indention($row['msg']);
      if (!$row['reply_id']) {
        $new_rows[$row['id']]['main'] = $row;
      } else{
        $new_rows[$row['reply_id']]['reply'][] = $row;
      }
    }
    return $new_rows;
  }
  
  // 削除フラグ関数
  function delete_flag($cn,$table_name,$del_id){
    $sql = "UPDATE ".$table_name." SET del_flg = 1 WHERE id = ".$del_id.";";
    mysqli_query($cn, $sql);
    mysqli_close($cn);
    return;
  }

  // id割り当て関数
  function id_allotment($cn,$table_name){
    $sql = "SELECT MAX(id) FROM ".$table_name.";";
    $result = mysqli_query($cn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row['MAX(id)'])) {
      $idcnt = $row['MAX(id)'] + 1;
    } else {
      $idcnt = 1;
    }
    return $idcnt;
  }

  //改行対応関数
  function indention($text){
    $text = str_replace("\r\n", "<br>", $text);
    $text = str_replace("\r", "<br>", $text);
    $text = str_replace("\n", "<br>", $text);
    return $text;
  }

  // insert関数
  function insert_into($cn,$table_name,$columns,$values){
    $sql = "INSERT INTO ".$table_name."(" .implode(',', $columns). ")VALUES(" . "'".implode("','", $values)."'" . ");";
    mysqli_query($cn, $sql);
    mysqli_close($cn);
    return;
  }