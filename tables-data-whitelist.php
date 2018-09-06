<?php include('template-parts/header.php') ;?>
<?php include('template-parts/left-panel.php'); ?>
<?php $filter =  $_GET['filter']; ?>
    <div id="right-panel" class="right-panel">
    <?php include('template-parts/top-bar.php'); ?>
    <?php include('template-parts/breadcrumbs.php'); ?>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Whitelist table</strong>
                        </div>
                        <div class="card-body">
                          <?php if(empty($filter)): ?>
                            <p>
                              Select a Job to view
                            </p>
                            <p>
                              <?php
                                $sqlJobsList = "SELECT * FROM jobs WHERE whitelisted = '1' ";
                                $resultJobsList = $link->query($sqlJobsList);
                                while($joblisting = mysqli_fetch_object($resultJobsList)): ?>

                                <a href="/admin/tables-data-whitelist.php?filter=<?=$joblisting->name?>" class="btn btn-primary"><?=$joblisting->label?></a>
                              <?php endwhile; ?>
                            </p>
                          <?php else: ?>
                                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Name</th>
                                        <th>Rank</th>
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $where = '';
                                        if(!empty($filter)){
                                          $where ="WHERE job = '{$filter}' ";
                                        }
                                        $sql = "SELECT * FROM whitelist_jobs {$where}";
                                        $result = $link->query($sql);
                                      ?>
                                      <?php while($job = mysqli_fetch_object($result)): ?>
                                        <?php
                                          $sqlUser = "SELECT name,id,online,identifier FROM users WHERE identifier = '{$job->identifier}' ";
                                          $resultUser = $link->query($sqlUser);
                                          while($user = mysqli_fetch_object($resultUser)){
                                            $username = $user->name;
                                            $userId = $user->id;
                                            $online = $user->online;
                                            $identifier = $user->identifier;
                                          }
                                        ?>
                                        <?php
                                          $sqlJobgrade = "SELECT label FROM job_grades WHERE job_name = '{$filter}' AND grade = '{$job->grade}' ";
                                          $resultJobgrade = $link->query($sqlJobgrade);
                                          while($jobGrade = mysqli_fetch_object($resultJobgrade)){
                                            $jobGradeLabel = $jobGrade->label;
                                          }
                                        ?>
                                        <tr>
                                          <td>
                                            <span class="status is-<?=($online == 1 ? 'online' : 'offline')?>"></span>
                                            <a href="/admin/view-user.php?userid=<?=$userId?>"><?=$username?></a>
                                          </td>
                                          <td><?=$jobGradeLabel?> <small>(<?=$job->grade?>)</small></td>
                                          <td>
                                            <!-- <a href="#" class="kick admin-action" data-steamid="<?=$identifier?>">Promote</a> -->
                                            <a href="#" class="ban admin-action" data-job="<?=$filter?>" data-steamid="<?=$identifier?>">Fire</a>
                                          </td>
                                        </tr>
                                      <?php endwhile; ?>
                                    </tbody>
                                  </table>
                              <?php endif; ?>
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
            if (confirm('Are you sure to fire?')) {
              var steamidSaved = jQuery(this).data('steamid')
              jQuery.ajax({    //create an ajax request to display.php
                type: "GET",
                data: {
                  steamid: jQuery(this).data('steamid'),
                  job:  jQuery(this).data('job')
                } ,
                url: "/admin/actions/firePlayer.php",
                dataType: "html",   //expect html to be returned
                success: function(response){
                    $('a.ban[data-steamid="'+steamidSaved+'"]').hide(300);
                }
              }); // end ajax
            } // end confirm
          });

        } );
    </script>
</body>
</html>
