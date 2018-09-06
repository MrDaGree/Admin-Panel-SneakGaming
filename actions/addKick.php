<?php
require '../config.php';
$steamid = $_GET['steamid'];
$reason = $_GET['reason'];

$sql = "INSERT INTO kicks (steamid,reason,kicked) VALUES  ( '{$steamid}' , '{$reason}' , '0')";

if ($link->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
