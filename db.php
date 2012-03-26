<?php
require('./config.php');

$db = mysql_connect($dbhost, $dbusername, $dbpassword);
mysql_select_db($dbname);

if(mysql_errno()) {
    throw new Exception(mysql_error());
}
?>
