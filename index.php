<?php include('template-parts/header.php'); ?>
<?php include('template-parts/session.php'); ?>
<?php include('template-parts/left-panel.php'); ?>
    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

      <?php include('template-parts/top-bar.php'); ?>

        <?php include('template-parts/breadcrumbs.php'); ?>

        <div class="content mt-3">

           <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                        </div>
                        <?php
                          $sql = "SELECT id FROM users";
                          $result = $link->query($sql);
                        ?>
                        <h4 class="mb-0">
                            <span class="count"><?=$result->num_rows;?></span>
                        </h4>
                        <p class="text-light">Users</p>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <?php
                          $sqlCars = "SELECT plate FROM owned_vehicles";
                          $resultCars = $link->query($sqlCars);
                        ?>
                        <h4 class="mb-0">
                            <span class="count"><?=$resultCars->num_rows?></span>
                        </h4>
                        <p class="text-light">Cars bought</p>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <?php
                          $sqlMoney = "SELECT money,bank FROM users";
                          $resultMoney = $link->query($sqlMoney);
                          $totalMoney = 0;
                          $totalBank = 0;
                          while($money = mysqli_fetch_object($resultMoney)){
                            $totalMoney = $totalMoney + $money->money;
                            $totalBank = $totalBank + $money->bank;
                          }

                        ?>
                        <h4 class="mb-0">
                            <span class="count"><?=$totalMoney?></span>
                        </h4>
                        <p class="text-light">Total money</p>

                    </div>


                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?=$totalBank?></span>
                        </h4>
                        <p class="text-light">Total Bank</p>


                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-5">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <?php
                          $sqlOnline = "SELECT online FROM users where online = 1";
                          $resultOnline = $link->query($sqlOnline);
                        ?>
                        <h4 class="mb-0">
                            <span class="count"><?=$resultOnline->num_rows?></span>
                        </h4>
                        <p class="text-light">Online Users</p>

                    </div>
                </div>
            </div>
            <!--/.col-->

        </div> <!-- .content -->
    </div><!-- /#right-panel -->
    <!-- Right Panel -->
<?php include('template-parts/footer.php'); ?>
