<?php
require 'config.php';
$steamid = $_GET['steamid'];
$bannedby = ' ( Banned by: ' . $_GET['bannedby'] . ' )';
$reason = $_GET['reason'] . $bannedby;
$license = $_GET['license'];
$timestap = strtotime("now");
$bantime = strtotime("+365 days");

$sql = "INSERT INTO ea_bans (expire, identifier, steam, reason) VALUES ( '{$bantime}', '{$license}', '{$steamid}' , '{$reason}'  )";

if ($link->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
