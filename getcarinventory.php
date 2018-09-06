<?php
require 'config.php';
$plate = $_GET['plate'];
  $sql = "SELECT * FROM truck_inventory WHERE plate = '{$plate}' ";
  $result = $link->query($sql);
?>
<?php if($result->num_rows <= 0 ): ?>
  Inventory is empty
<?php else: ?>
<?php while($inventory = mysqli_fetch_object($result)): ?>
  <div class="row pt-2 pb-2 bbrow">
    <div class="col-lg-7"><?=$inventory->name?></div>
    <div class="col-lg-4"><?=$inventory->count?></div>
  </div>
<?php endwhile; ?>
<?php endif; ?>
