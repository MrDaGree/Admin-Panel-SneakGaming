<?php
require '../config.php';
$steamid = $_GET['steamid'];
$job = $_GET['job'];

$sql = "DELETE FROM whitelist_jobs WHERE identifier = '{$steamid}' AND  job = '{$job}' ";

if ($link->query($sql) === TRUE) {
    echo "Car deleted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
