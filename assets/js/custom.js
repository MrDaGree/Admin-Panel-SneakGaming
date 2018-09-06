document.addEventListener("DOMContentLoaded",function(event){
  jQuery('button[data-toggle="modal"]').click(function(event) {
    jQuery.ajax({    //create an ajax request to display.php
      type: "GET",
      data: {
        plate: jQuery(this).data('plate')
      } ,
      url: "/admin/actions/getcarinventory.php",
      dataType: "html",   //expect html to be returned
      success: function(response){
          jQuery(".modal-title").html('Inventory');
          jQuery(".modal-body p").html(response);
      }
    });

    jQuery('#bootstrap-data-table-export').DataTable();
  });

  // Kick Player
  jQuery(document).on("click", "a.kick",function(e) {
    e.preventDefault;
    var reasonInput = prompt("Reason", "Kicked by the server");
    if (reasonInput !== null && reasonInput !== "") {
      console.log(reasonInput);
      var steamidSaved = jQuery(this).data('steamid')
      jQuery.ajax({    //create an ajax request to display.php
        type: "GET",
        data: {
          steamid: jQuery(this).data('steamid'),
          reason: reasonInput
        } ,
        url: "/admin/actions/addKick.php",
        dataType: "html",   //expect html to be returned
        success: function(response){
            jQuery('a.kick[data-steamid="'+steamidSaved+'"]').hide(300);
        }
      }); // end ajax
    }else{
      e.preventDefault;
    } // end confirm
  });

  // Ban player
  jQuery(document).on("click", "a.ban",function(event) {
    event.preventDefault;
    var reasonInput = prompt("Perma ban Reason: ", "");
    if (reasonInput !== null && reasonInput !== "") {
      var steamidSaved = jQuery(this).data('steamid');
      jQuery.ajax({    //create an ajax request to display.php
        type: "GET",
        data: {
          steamid: jQuery(this).data('steamid'),
          bannedby: jQuery('.current_loggedin_user').val(),
          license: jQuery(this).data('license'),
          username: jQuery(this).data('username'),
          reason: reasonInput
        } ,
        url: "/admin/actions/addBan.php",
        dataType: "html",   //expect html to be returned
        success: function(response){
            jQuery('a.ban[data-steamid="'+steamidSaved+'"]').hide(300);
        }
      }); // end ajax
    } // end confirm
  });

  // ban user-view
  jQuery(document).on("click", "a.banuser",function(e) {
    e.preventDefault;
    jQuery('.ban-player').addClass('show');
    jQuery('html,body').animate({
        scrollTop: jQuery(".ban-player").offset().top
    }, 'slow');
  });

  //cancelban
  jQuery(document).on("click", "a.cancelban",function(e) {
    e.preventDefault;
    jQuery('.ban-player').removeClass('show');
  });

  //delete car
  jQuery(document).on("click", "a.delcar",function(e) {
    e.preventDefault;
    if (confirm('Are you sure to delete car?')) {
      var carPlate = jQuery(this).data('plate');
      jQuery.ajax({    //create an ajax request to display.php
        type: "GET",
        data: {
          steamid: jQuery(this).data('steamid'),
          plate: jQuery(this).data('plate')
        } ,
        url: "/admin/actions/deleteCar.php",
        dataType: "html",   //expect html to be returned
        success: function(response){
            jQuery('a.delcar[data-plate="'+carPlate+'"]').parent().parent().hide(300);
        }
      }); // end ajax
    } // end confirm
  });

  //remove item
  jQuery(document).on("click", "a.remove-item",function(event) {
    event.preventDefault;
    if (confirm('Are you sure to delete item?')) {
      var itemID = jQuery(this).data('itemid');
      jQuery.ajax({    //create an ajax request to display.php
        type: "GET",
        data: {
          itemid: itemID,
        } ,
        url: "/admin/actions/removeItem.php",
        dataType: "html",   //expect html to be returned
        success: function(response){
            jQuery('a.remove-item[data-itemid="'+itemID+'"]').parent().parent().hide(300);
        }
      }); // end ajax
    } // end confirm
  });

  //Update user
  jQuery(document).on("click", "a.save",function(event) {
      var name = jQuery(this).attr('name');
      console.log(jQuery(this).parent('div input'));

      // jQuery.ajax({    //create an ajax request to display.php
      //   type: "GET",
      //   data: {
      //     steamid: jQuery(this).data('steamid'),
      //     reason: reasonInput
      //   } ,
      //   url: "/admin/actions/addKick.php",
      //   dataType: "html",   //expect html to be returned
      //   success: function(response){
      //       jQuery('a.kick[data-steamid="'+steamidSaved+'"]').hide(300);
      //   }
      // }); // end ajax
     //} // end confirm
  });

  jQuery(document).on("click", "div.user-value.offline", function(e){
    jQuery(jQuery('.current-value.'+ jQuery(this).data('action'))).hide();
    console.log('.update-input.' + jQuery(this).data('action'));
    jQuery('.update-input.' + jQuery(this).data('action') ).show();
  });
});
