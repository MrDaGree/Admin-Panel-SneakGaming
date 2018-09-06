<?php
if($_SESSION["loggedin"] === false or empty($_SESSION['loggedin'])  ){
  header("location: page-login.php");
  exit;
}
