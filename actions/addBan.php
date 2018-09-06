<?php
require '../config.php';
$steamid = $_GET['steamid'];
$reason = ($_GET['reason'] == '' ? 'No reason specified' : $_GET['reason']);
$license = $_GET['license'];
$username = $_GET['username'];
$reason = $reason . ' ( Nickname: '.$username.' ), Banned by: '  . $_GET['bannedby'];

$timestap = strtotime("now");
$checkSql = "SELECT identifier, steam FROM ea_bans WHERE identifier = '{$license}' OR steam = '{$steamid}'";
$resultCheck = $link->query($checkSql);
$resultCheckCount = $resultCheck->num_rows;
if(!empty($_GET['actionbyuser'])){
  if(!empty($_GET['expires'])){
    $expireselect = $_GET['expires'];
    if($expireselect == '1w'){
      $bantime = strtotime("+7 days");
    }elseif($expireselect == '2w'){
      $bantime = strtotime("+14 days");
    }elseif($expireselect == '3w'){
      $bantime = strtotime("+21 days");
    }elseif($expireselect == '1m'){
      $bantime = strtotime("+31 days");
    }elseif($expireselect == '2m'){
      $bantime = strtotime("+62 days");
    }elseif($expireselect == '3m'){
      $bantime = strtotime("+90 days");
    }elseif($expireselect == '6m'){
      $bantime = strtotime("+184 days");
    }elseif($expireselect == '1y'){
      $bantime = strtotime("+365 days");
    }elseif($expireselect == 'perma'){
      $bantime = strtotime("+865 days");
    }else{
      $bantime = strtotime("+865 days");
    }
  }else{
    $bantime = strtotime("+765 days");
  }
}else{
  $bantime = strtotime("+765 days");
}

if($resultCheckCount > 0){
  echo 'User already banned';
  if(!empty($_GET['userid'])){
    header('location: /admin/view-user.php?userid='.$_GET['userid'].'&action=error1');
  }
}else{
  $sql = "INSERT INTO ea_bans (expire, identifier, steam, reason, steamname) VALUES ( '{$bantime}', '{$license}', '{$steamid}' , '{$reason}', '{$username}'  )";
  if ($link->query($sql) === TRUE) {
      echo "New ban record created successfully";
      $sql2 = "INSERT INTO kicks (steamid,reason,kicked) VALUES  ( '{$steamid}' , '{$reason}' , '0')";
      if ($link->query($sql2) === TRUE) {
          echo "New kick record created successfully";
      }
      if(!empty($_GET['userid'])){
        header('location: /admin/view-user.php?userid='.$_GET['userid'].'&action=done');
      }
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      if(!empty($_GET['userid'])){
        header('location: /admin/view-user.php?userid='.$_GET['userid'].'&action=error');
      }
  }
}
