<?php include('template-parts/header.php') ;?>
<?php include('template-parts/left-panel.php'); ?>

    <div id="right-panel" class="right-panel">
      <?php include('template-parts/top-bar.php'); ?>
      <?php include('template-parts/breadcrumbs.php'); ?>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">User table</strong>
                        </div>
                        <div class="card-body">
                          <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>Steam name</th>
                                <th>reason</th>
                                <th>expire</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $sql = "SELECT * FROM ea_bans";
                                $result = $link->query($sql);
                              ?>
                              <?php while($user = mysqli_fetch_object($result)): ?>
                              <?php
                                if($user->expire == '10444633200'){
                                  $expire = 'Perma';
                                }else{
                                  $expire = date('d-m-Y', $user->expire);
                                }

                                if( empty($user->steamname) ){
                                  $name = explode("( Nickname: ",$user->reason);
                                  $name = explode(" )",$name[1]);
                                  $name = $name[0];
                                }else{
                                  $name = $user->steamname;
                                }

                              ?>
                                <tr>
                                  <td><?=$name?></td>
                                  <td><?=$user->reason?></td>
                                  <td><?=$expire?> </td>
                                  <td>
                                    <a href="#" class="ban admin-action" data-banid="<?=$user->banid?>">Unban</a>
                                  </td>
                                </tr>
                              <?php endwhile; ?>
                            </tbody>
                          </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div>

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/lib/data-table/datatables-init.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
          jQuery('#bootstrap-data-table-export').DataTable();
          jQuery(document).on("click", "a.ban",function(event) {
            event.preventDefault;
            if (confirm('Are you sure to unban?')) {
              var banId = jQuery(this).data('banid');
              jQuery.ajax({    //create an ajax request to display.php
                type: "GET",
                data: {
                  steamid: jQuery(this).data('steamid'),
                  banid: jQuery(this).data('banid'),
                } ,
                url: "/admin/actions/removeBan.php",
                dataType: "html",   //expect html to be returned
                success: function(response){
                    jQuery('a.ban[data-banid="'+banId+'"]').parent().parent().hide(300);
                }
              }); // end ajax
            } // end confirm
          });

      } );

    </script>
</body>
</html>
