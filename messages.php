<?php
	require_once('auth.php');
  require_once('util.php');  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>
        <?php require("chunks/scripts.php"); ?>	
       <script type="text/javascript" src="./scripts/messages.js"></script>
       <script type="text/javascript">var currentuser=<?php echo $_SESSION['SESS_MEMBER_ID'] ?>;</script>    
		<title>RUConnected | Messages</title>
	</head>
  <body>
    <?php require("chunks/header.php"); ?>	
  	<div id="content">
         <?php require("chunks/leftbar.php"); ?>
         <div class="rightbar">
           <h1 align="center">Messages</h1>
           <div class="messagearea"></div>
         </div>
				 <div class="clear"></div>
  	</div>
  </body>
</html>
