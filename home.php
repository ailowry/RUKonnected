<?php
	require_once('auth.php');
	require_once('util.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php getHeader('Home'); ?>
<body>
<div class="header" >
	<div class="userInfo">
	<a href="home.php">Home</a> | <a href="#"><?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'];?></a> | <a href="logout.php">Logout</a>
	</div>
</div>

<p>This is a password protected area only accessible to Users. ...what hackers!</p>

</body>
</html>
