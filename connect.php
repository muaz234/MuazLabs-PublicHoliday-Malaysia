<?php
$build_server = "localhost";
$build_server_db = "calendar";
$build_server_port = "3306";
$build_server_l = "root";
$build_server_p = "";
$build_server_prefix = "";

define('MYSERVER', $build_server);
define('MYPORT', $build_server_port);
define('MYL', $build_server_l);
define('MYP', $build_server_p);
define('MYD', $build_server_db);
define("MYPREFIX",$build_server_prefix);
define("ENVIRONMENT","BUILD");

$db = mysqli_connect(MYSERVER, MYL, MYP, MYD, MYPORT) or die(mysqli_error($db));

//SET SESSION TIMEZONE
mysqli_query($db, "SET @@session.time_zone='+08:00'") or die(mysqli_error($db));

