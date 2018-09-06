<?php include('template-parts/header.php'); ?>
<?php include('template-parts/session.php'); ?>
<?php include('template-parts/left-panel.php'); ?>
<?php
  if(isset($_POST)){
    updateUserInfo($_POST);
  }
  $userid = $_GET['userid'];
?>
    <div id="right-panel" class="right-panel">
      <?php if($_GET['action'] == 'done'): ?>
      <div class="col-sm-12 mt-5">
          <div class="alert  alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-success">Success</span> Successfully banned user.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      </div>
      <?php endif;?>
      <?php if($_GET['action'] == 'error1'): ?>
      <div class="col-sm-12 mt-5">
          <div class="alert  alert-danger alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-danger">Failed</span> User is already banned.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      </div>
      <?php endif;?>

        <div class="content mt-3">
            <div class="animated fadeIn">
              <?php if(empty($userid)): ?>
                <div class="row">
                  <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <h4>No user selected</h4>
                          </div>
                          <div class="card-body">
                            <p>Find a usere here</p>
                          </div>
                      </div>
                  </div>
                </div>
              <?php else: ?>
                <?php
                  $userSql = " SELECT * FROM ".USERS_TABLE." WHERE ".USERS_TABLE.".id = {$userid}";
                  $resultUser = $link->query($userSql);

                while($user = mysqli_fetch_object($resultUser)){
                    $identifier = $user->identifier;
                    $license = $user->license;
                    $steamname = $user->name;
                    $money = $user->money;
                    $bank = $user->bank;
                    $loadout = $user->loadout;
                    $timeplayed = $user->timeplayed;
                    $job = $user->job;
                    $jobGrade = $user->job_grade;
                    $online = $user->online;
                    $userId = $user->id;
                }

                  $carSql = " SELECT * FROM ".OWNED_VEHICLES_TABLE." WHERE ".OWNED_VEHICLES_OWNER_COLUMN." = '{$identifier}'";
                  $resultCars = $link->query($carSql);
                  $ownedCarsCount = $resultCars->num_rows;

                  $blackMoneySql = " SELECT * FROM ".USER_ACCOUNTS_TABLE." WHERE ".USER_ACCOUNTS_IDENTIFIER_COLUMN." = '{$identifier}'";
                  $resultBlackMoney = $link->query($blackMoneySql);
                  $resultBlackMoneyCount = $resultBlackMoney->num_rows;
                    while($bm = mysqli_fetch_object($resultBlackMoney)){
                      $blackmoney = $bm->money;
                    }
                  $d = floor ($timeplayed / 1440);
                  $h = floor (($timeplayed - $d * 1440) / 60);
                  $m = $timeplayed - ($d * 1440) - ($h * 60);
                ?>
                <?php if($msg): ?>
                  <div class="row">
                    <div class="card-body">
                      <?=$msg?>
                    </div>
                  </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card userinfo">
                            <div class="card-header">
                                <h4><?=$steamname?> <?php if(checkIfBanned($identifier)): ?>[Banned]<?php endif;?></h4>
                            </div>
                            <div class="card-body user-info-list">
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-6 col-xs-12 p-0">Status</div>
                                <div class="col-lg-5 col-xs-12"><?=($online == 0 ? "Offline" : "Online")?></small></div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1 hidden-xs">👔</div>
                                <div class="col-lg-6 col-xs-12 p-0">Job</div>
                                <div class="col-lg-5 col-xs-12"><?=ucfirst($job)?> <small>(<?=$jobGrade?>)</small></div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1">💰</div>
                                <div class="col-lg-6 col-xs-12 p-0">Money</div>
                                <div class="col-lg-5 col-xs-12">
                                  <div class="user-value <?=($online == 0 ? "offline" : "online")?>  money"  data-action="money">
                                    <div class="current-value money">$ <?=thousandsCurrencyFormat($money)?></div>
                                    <?=inlineEdit('money', $userId, $money)?>
                                  </div>
                                </div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1">💳</div>
                                <div class="col-lg-6 p-0">Bank</div>
                                <div class="col-lg-5">
                                  <div class="user-value <?=($online == 0 ? "offline" : "online")?> bank" data-action="bank">
                                    <div class="current-value bank">$ <?=thousandsCurrencyFormat($bank)?></div>
                                    <?=inlineEdit('bank', $userId, $bank)?>
                                  </div>
                                </div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1">💵</div>
                                <div class="col-lg-6 p-0">Blackmoney</div>
                                <div class="col-lg-5">$ <?=$blackmoney?></div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1">🚗</div>
                                <div class="col-lg-6 p-0">Owned Vehicles</div>
                                <div class="col-lg-5"><?=$ownedCarsCount?></div>
                              </div>
                              <div class="row pt-1 pb-2">
                                <div class="col-lg-1">⏱️</div>
                                <div class="col-lg-6 p-0">Time played</div>
                                <div class="col-lg-5"><?=$d?> days <?=$h?> hours <?=$m?> min</div>
                              </div>

                            </div>
                        </div>
                    </div>
                    <!-- /# column -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Loadout</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list">
                                  <?php
                                  $loadout = json_decode($loadout, true);
                                  if(empty($loadout)):
                                    echo '<p>No weapons found</p>';
                                  else:
                                    foreach($loadout as $weapon):
                                      $weaponName = $weapon['name'];
                                      $weaponName = str_replace("WEAPON_","", $weaponName);
                                      $weaponName = strtolower($weaponName);
                                    ?>
                                    <li class="list-item"><?=ucfirst($weaponName)?> - <?=$weapon['ammo']?> </li>
                                    <?php endforeach; ?>
                                  <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                    <div class="row">

                        <?php if(SHOW_CAR_LIST): ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Car list</h4>
                                </div>
                                <div class="card-body cars-list">
                                  <?php if($resultCars->num_rows > 0):?>
                                  <?php while($car = mysqli_fetch_object($resultCars)): ?>
                                    <div class="row pt-1 pb-1 bbrow">
                                      <div class="col-lg-12">
                                        <a href="#" class="delcar" data-steamid="<?=$car->owner?>" data-plate="<?=$car->plate?>"><?=$car->modelname?></a>
                                        <?php
                                        $plate = $car->plate;
                                        $trunkSql = " SELECT * FROM truck_inventory WHERE plate = '{$plate}' AND count != '0'";
                                        $resultTrunk = $link->query($trunkSql);
                                        if($resultTrunk->num_rows > 0):
                                        ?>
                                          <button type="button" class="btn btn-secondary mb-1 viewtrunkbtn" data-plate="<?=$plate?>" data-toggle="modal" data-target="#largeModal">View trunk</button>
                                        <?php endif;?>
                                      </div>
                                    </div>
                                  <?php endwhile; ?>
                                <?php else: ?>
                                  <p>User has no cars</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- /# column -->

                        <?php if(SHOW_PROPERTIES): ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Inventory</h4>
                                </div>
                                <div class="card-body">
                                  <?php
                                  $inventorySql = " SELECT * FROM user_inventory WHERE identifier = '{$identifier}'";
                                  $resultInventory = $link->query($inventorySql);
                                  ?>
                                  <?php if($resultInventory->num_rows > 0):?>
                                  <?php while($item = mysqli_fetch_object($resultInventory)): ?>
                                  <?php if($item->count != '0'): ?>
                                      <div class="row pb-2 pt-2">
                                        <div class="col-lg-7">
                                          <a href="#" class="remove-item" data-itemid="<?=$item->id?>"><?=$item->item?></a>
                                        </div>
                                        <div class="col-lg-4">
                                          <?=$item->count?>
                                        </div>
                                      </div>
                                    <?php endif; ?>
                                  <?php endwhile; ?>

                                <?php else: ?>
                                    <p>User has no properties</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div><!-- END ROW -->

                    <div class="row">
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-header">
                                  <h4>Account Data</h4>
                              </div>
                              <div class="card-body">
                                <?php
                                $accountSQL = " SELECT * FROM addon_account_data WHERE owner = '{$identifier}'";
                                $resultAccount = $link->query($accountSQL);
                                ?>
                                <?php if($resultAccount->num_rows > 0):?>
                                <?php while($account = mysqli_fetch_object($resultAccount)): ?>
                                    <div class="row pb-2 pt-2">
                                      <div class="col-lg-5">
                                        <?=$account->account_name?>
                                      </div>
                                      <div class="col-lg-7">
                                        <?=thousandsCurrencyFormat($account->money)?>
                                      </div>
                                    </div>
                                <?php endwhile; ?>
                                <div class="row pb-2 pt-2">
                                  <div class="col-lg-5">
                                    Steamid
                                  </div>
                                  <div class="col-lg-7">
                                    <?=$identifier?>
                                  </div>
                                </div>
                                <div class="row pb-2 pt-2">
                                  <div class="col-lg-5">
                                    License
                                  </div>
                                  <div class="col-lg-7">
                                    <?=str_replace("license:","",$license)?>
                                  </div>
                                </div>
                              <?php else: ?>
                                  <p>User has no data</p>
                              <?php endif; ?>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-header">
                                  <h4>Licenses</h4>
                              </div>
                              <div class="card-body">
                                <?php
                                $lisenceSQL = " SELECT * FROM user_license WHERE owner = '{$identifier}'";
                                $resultLicense = $link->query($lisenceSQL);
                                ?>
                                <?php if($resultLicense->num_rows > 0):?>
                                <?php while($licence = mysqli_fetch_object($resultLicense)): ?>
                                    <div class="row pb-2 pt-2">
                                      <div class="col-lg-12">
                                        <?=$licence->type?>
                                      </div>
                                    </div>
                                <?php endwhile; ?>
                              <?php else: ?>
                                  <p>User has no licenses</p>
                              <?php endif; ?>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if(SHOW_PROPERTIES): ?>
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-header">
                                  <h4>Properties</h4>
                              </div>
                              <div class="card-body">
                                <?php
                                $housesSql = " SELECT * FROM owned_properties WHERE owner = '{$identifier}'";
                                $resultHouses = $link->query($housesSql);
                                ?>
                                <?php if($resultHouses->num_rows > 0):?>
                                <?php while($house = mysqli_fetch_object($resultHouses)): ?>
                                    <div class="row pb-2 pt-2">
                                      <div class="col-lg-7">
                                        <?=$house->name?>
                                      </div>
                                      <div class="col-lg-4">
                                        <?php if ($house->rented == 0 ):?>
                                            B: <?=thousandsCurrencyFormat($house->price)?>
                                        <?php else: ?>
                                            R: <?=thousandsCurrencyFormat($house->price)?>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                <?php endwhile; ?>

                              <?php else: ?>
                                  <p>User has no properties</p>
                              <?php endif; ?>
                              </div>
                          </div>
                      </div>
                      <?php endif;?>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-header">
                                  <h4>Admin actions</h4>
                              </div>
                              <div class="card-body">
                                <?php
                                $userActionSQL = " SELECT * FROM users WHERE identifier = '{$identifier}'";
                                $resultUserAction = $link->query($userActionSQL);
                                ?>
                                <?php if($resultUserAction->num_rows > 0):?>
                                  <?php while($account = mysqli_fetch_object($resultUserAction)): ?>
                                      <div class="row pb-2 pt-2">
                                        <div class="col-lg-12">
                                          <a href="#" class="kick admin-action" data-steamid="<?=$account->identifier?>">Kick</a>
                                          <a href="#" class="banuser admin-action" data-license="<?=$account->license?>" data-steamid="<?=$account->identifier?>">Ban</a>

                                          <div class="ban-player row mb-3 mt-3">
                                              <form action="/admin/actions/addBan.php" method="SELF">
                                                <input type="hidden" name="license" value="<?=$account->license?>">
                                                <input type="hidden" name="userid" value="<?=$account->id?>">
                                                <input type="hidden" name="username" value="<?=$account->name?>">
                                                <input type="hidden" name="steamid" value="<?=$account->identifier?>">
                                                <input type="hidden" name="bannedby" value="<?=$_SESSION['username'];?>">
                                                <input type="hidden" name="actionbyuser" value="yes">

                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label>Expire</label>
                                                      <select name="expires" class="form-control">
                                                        <option value="1w">1 week</option>
                                                        <option value="2w">2 weeks</option>
                                                        <option value="3w">3 weeks</option>
                                                        <option value="1m">1 month</option>
                                                        <option value="2m">2 months</option>
                                                        <option value="3m">3 months</option>
                                                        <option value="6m">6 months</option>
                                                        <option value="1y">1 year</option>
                                                        <option value="perma">perma</option>
                                                      </select>
                                                  </div>
                                                </div>
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label>Reason</label>
                                                      <input type="text" name="reason" class="form-control" placeholder="Reason">
                                                  </div>
                                                </div>
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                      <input type="submit" name="ban" value="Ban now"> <a href="#" class="cancelban">cancel</a>
                                                  </div>
                                                </div>
                                              </form>
                                          </div>
                                        </div>
                                      </div>
                                  <?php endwhile; ?>
                                <?php endif;?>
                              </div>
                          </div>
                      </div>
                    </div>
              <?php endif; ?>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="largeModalLabel">Loading info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Loading....
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>
<?php include('template-parts/footer.php'); ?>
