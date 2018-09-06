<?php
require '../config.php';
$steamid = $_GET['steamid'];
$plate = $_GET['plate'];

$sql = "DELETE FROM owned_vehicles WHERE owner = '{$steamid}' AND plate =  '{$plate}' ";

if ($link->query($sql) === TRUE) {
    echo "Car deleted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
