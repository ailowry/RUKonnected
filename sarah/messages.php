<?php
	require_once('auth.php');
	require_once('util.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>

		<title>RUConnected | Messages</title>
	
	</head>
  <body>
	<?php require_once('header.php') ?>
	<div id="content">
	  <?php require_once('leftbar.php'); ?>
		<div class="message">
				<img src="http://www.radford.edu/jpittges/Images/JPittges_0806_sm.jpg"
					 alt="Dr. Pittges" />
				<a href="Dr. Jeff Pittges" />Dr. Jeff Pittges</a><br />
				<span>Tell 'em Phillips!</span>
				<span class="messageDate">April 11</span>
			</div>
			<div class="message">
				<img src="http://fds.asp.radford.edu/images/rphillip.jpg"
					 alt="Dr. Phillips" />
				<a href="Dr. Bob Phillips" />Dr. Bob Phillips</a><br />
				<span>Database Rules!</span>
				<span class="messageDate">April 11</span>
			</div>		
	  	 
					
	</div>
  </body>
</html>
