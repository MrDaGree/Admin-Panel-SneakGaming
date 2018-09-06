<?php
require '../config.php';
$banid = $_GET['banid'];


$sql = "DELETE FROM ".USERS_BANNED_TABLE." WHERE ".USERS_BANNED_ID_COLUMN." = '{$banid}' ";

if ($link->query($sql) === TRUE) {
    echo "Ban removed";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
