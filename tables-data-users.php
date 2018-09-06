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
                                <th>Money</th>
                                <th>Bank</th>
                                <th>Job</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $where = '';
                                if(!empty($_GET['filter'])){
                                  if($_GET['filter'] == 'online'){
                                    $where = 'WHERE online = 1';
                                  }
                                }
                                $sql = "SELECT id,job,job_grade,name,money,bank,identifier,online,license FROM users {$where}";
                                $result = $link->query($sql);
                              ?>
                              <?php while($user = mysqli_fetch_object($result)): ?>
                                <tr>
                                  <td>
                                    <span class="status is-<?=($user->online == 1 ? 'online' : 'offline')?>"></span>
                                    <a href="/admin/view-user.php?userid=<?=$user->id?>">
                                      <?=$user->name?>
                                      <?php if(checkIfBanned($user->identifier)): ?>[Banned]<?php endif;?>
                                    </a>
                                  </td>
                                  <td><?=$user->money?></td>
                                  <td><?=$user->bank?></td>
                                  <td><?=$user->job?> <small>(<?=$user->job_grade?>)</small></td>
                                  <td>
                                    <a href="#" class="kick admin-action" data-steamid="<?=$user->identifier?>">Kick</a>
                                    <?php if(!checkIfBanned($user->identifier)): ?>
                                      <a href="#" class="ban admin-action" data-license="<?=$user->license?>" data-username="<?=$user->name?>" data-steamid="<?=$user->identifier?>">Ban</a>
                                    <?php endif; ?>
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

          jQuery(document).on("click", "a.kick",function(event) {
            var reasonInput = prompt("Reason", "");
            if (reasonInput != null || reasonInput != "") {
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
                    $('a.kick[data-steamid="'+steamidSaved+'"]').hide(300);
                }
              }); // end ajax
            } // end confirm
          });

          jQuery(document).on("click", "a.ban",function(event) {
            if (confirm('Are you sure to ban?')) {
              var steamidSaved = jQuery(this).data('steamid')
              jQuery.ajax({    //create an ajax request to display.php
                type: "GET",
                data: {
                  steamid: jQuery(this).data('steamid'),
                  bannedby: '<?=$_SESSION["username"]?>',
                  license: jQuery(this).data('license'),
                  username: jQuery(this).data('username')
                } ,
                url: "/admin/actions/addBan.php",
                dataType: "html",   //expect html to be returned
                success: function(response){
                    jQuery('a.ban[data-steamid="'+steamidSaved+'"]').hide(300);
                }
              }); // end ajax
            } // end confirm
          });

      } );

    </script>


</body>
</html>
