<?php
	require_once('auth.php');
	require_once('util.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>
        <link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />
        <script type="text/javascript" src="./scripts/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="./scripts/jquery-ui-1.8.19.custom.min.js"></script>
        <script type="text/javascript" src="./scripts/mustache.js"></script>
        <script type="text/javascript" src="./scripts/common.js"></script>
        <script type="text/javascript" src="./scripts/feed.js"></script>

		<title>RUConnected | Home</title>
	
	</head>
	
  <body>
	<div id="header">
     <img src="./imgs/logo.png" alt="RUConnected" border=0 />
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
		  	 <div style="margin-left:12px;width:150px;border-bottom:#f0f0f0 1px solid;"></div> 	 
	  	 </div>
         <div class="rightbar">
             <form id="postform">
                <textarea name="content" onfocus="if(this.value=='Make new post') {
                    this.value = ''}">Make new post</textarea>
                <input type="button" value="Comment"
                    onclick="makePost($(this).parent())">
             </form>
             <div class="postarea">
             </div>
         </div>
         <div class="clear"></div>
         <div class="alert" style="display:none"></div>
	  	 
	  	 
  	</div>
  
  </body>
</html>
