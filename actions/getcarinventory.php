<?php
require '../config.php';
$plate = $_GET['plate'];
  $sql = "SELECT * FROM truck_inventory WHERE plate = '{$plate}' ";
  $result = $link->query($sql);
?>
<?php if($result->num_rows <= 0 ): ?>
  Inventory is empty
<?php else: ?>
<?php while($inventory = mysqli_fetch_object($result)): ?>
  <div class="row pt-2 pb-2 bbrow">
      <div class="col-lg-7"><a href="#" class="removeitem" data-id="<?=$inventory->id?>"><?=$inventory->name?></a></div>
    <div class="col-lg-4"><?=$inventory->count?></div>
  </div>
<?php endwhile; ?>
<?php endif; ?>

<script>
jQuery(document).on("click", "a.removeitem",function(event) {
  event.preventDefault;
  if (confirm('Are you sure to remove this item?')) {
    var itemIdsave = jQuery(this).data('id')
    jQuery.ajax({    //create an ajax request to display.php
      type: "GET",
      data: {
        itemid: jQuery(this).data('id')
      } ,
      url: "/admin/actions/deleteItem.php",
      dataType: "html",   //expect html to be returned
      success: function(response){
          jQuery('a.removeitem[data-id="'+itemIdsave+'"]').parent().parent().hide(300);
      }
    }); // end ajax
  } // end confirm
});
</script>
