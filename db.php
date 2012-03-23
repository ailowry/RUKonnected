<?php
$host = "50.57.138.7";
$username = "rubook";
$password = "teamsara";
$dbname = "rubook";

$db = mysql_connect($host, $username, $password);
mysql_select_db($dbname);

if(mysql_errno()) {
    throw new Exception(mysql_error());
}
?>
