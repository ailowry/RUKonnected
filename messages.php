<?php
	require_once('auth.php');
  require_once('util.php');  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>
       <script type="text/javascript" src="./scripts/jquery-1.7.2.min.js"></script>
       <script type="text/javascript" src="./scripts/mustache.js"></script>
       <script type="text/javascript" src="./scripts/messages.js"></script>
       <script type="text/javascript">var currentuser=<?php echo $_SESSION['SESS_MEMBER_ID'] ?>;</script>    
		<title>RUConnected | Messages</title>
	</head>
  <body>
	<div id="header">
	 <a href="home.php"><img src="./imgs/logo.png" alt="RUConnected" title="RUConnected" border=0 /></a>
        <form id="friendfinder">
            <input id="friendfinderinput" type="text" />
            <input id="friendrequestbutton" type="button"
                value="Send friend request" onclick="makeFriendRequest()" />
        </form>
         <span style="margin-top:10px;font-size:22px;color:#fff;float:right;margin-right:15px;">
        <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?> |
        <a href="./logout.php">Logout</a></span>
	 
	</div>
  	<div id="content">
	  	 <div class="leftbar">
		  	 <?php echo "<img width=150px src='".$_SESSION['SESS_PICTURE']."' alt='' />"; ?>
		  	 <br/>
			 <div class="UsersName">
			 <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?>
		  	 </div>
			 <div style="margin-left:12px;width:150px;border-bottom:#f0f0f0 1px solid;"></div> 	
			 <div style="margin-left:10px;margin-top:7px;">
				<a style="text-decoration:none;" href="friends.php">Your Friends</a><br />
				<a style="text-decoration:none;" href="messages.php">Your Messages</a><br />
			 </div>
	  	 </div>
         <div class="rightbar">
           <h1 align="center">Messages</h1>
           <div class="messagearea"></div>
         </div>
				 <div class="clear"></div>
  	</div>
  </body>
</html>
