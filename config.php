<?php
define('DB_SERVER', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

// Show data in view user
define('SHOW_PROPERTIES', true);
define('SHOW_CAR_LIST', true);

// Set Tables and Columns
define('USERS_TABLE', 'users');

define('USERS_BANNED_TABLE', 'ea_bans');
define('USERS_BANNED_ID_COLUMN', 'banid');

define('OWNED_VEHICLES_TABLE', 'owned_vehicles');
define('OWNED_VEHICLES_OWNER_COLUMN', 'owner');

define('TRUNK_INVENTORY_TABLE', 'truck_inventory');
define('TRUNK_INVENTORY_COLUM_ID', 'id');

define('USER_ACCOUNTS_TABLE', 'user_accounts');
define('USER_ACCOUNTS_IDENTIFIER_COLUMN', 'identifier');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
