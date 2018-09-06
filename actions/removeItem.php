<?php
require '../config.php';
$itemID = $_GET['itemid'];

$sql = "UPDATE user_inventory SET count = '0' WHERE id = '{$itemID}'";

if ($link->query($sql) === TRUE) {
    echo "Item deleted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
