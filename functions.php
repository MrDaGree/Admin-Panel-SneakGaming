<?php
session_start();
include('config.php');

function thousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array(' k', ' m', ' b', ' t');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

function updateUserInfo($data){
    global $link;
    $action = $data['action'];
    $value  = $data[$action];
    $userId = $data['userid'];
    $sql = "UPDATE users SET {$action} = '{$value}' WHERE id = '{$userId}' ";

    if ($link->query($sql) === TRUE) {
        $msg = $action . ' updated!';
    } else {
        $msg = 'Error';
    }
}

function checkIfBanned($steamid){
  global $link;
  $sql = "SELECT * FROM ea_bans WHERE steam = '{$steamid}'";
  $result = $link->query($sql);
  $countRows = $result->num_rows;
  if($countRows > 0){
    return true;
  }else{
    return false;
  }
}

function inlineEdit($action,$userid,$currentValue){
  ob_start();
  ?>
  <div class="update-input <?=$action?> row">
    <form id="<?=$action?>" method="POST" class="inline-form" enctype="multipart/form-data">
      <input type="hidden" name="action" value="<?=$action?>">
      <input type="hidden" name="userid" value="<?=$userid?>">
      <div class="col-lg-8"><input name="<?=$action?>" type="text" value="<?=$currentValue?>"></div>
      <div class="col-lg-4"><input type="submit" name="save_<?=$action?>" value="save"></div>
    </form>
  </div>
  <?php
  $data = ob_get_contents();
  ob_end_flush();
}
