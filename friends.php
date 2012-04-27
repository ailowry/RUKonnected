<?php
	require_once('auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>

		<title>RUConnected | My Friends</title>
	
	</head>
	
  <body>
	<div id="header">
	 <h3><a href="home.php"><img src="./imgs/logo.png" alt="RUConnected" title="RUConnected" border=0 /></a>
		 <span style="margin-top:10px;font-size:22px;color:#fff;float:right;margin-right:15px;"> 
		 <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?> | <a href="./logout.php">Logout</a>
		 </span>
	 </h3>
	</div>
  	
  	<div id="content">
	  	 <div class="leftbar">
		  	 <?php echo "<img width=150px src='".$_SESSION['SESS_PICTURE']."' alt='' />"; ?>
		  	 <br/>
			 <div class="UsersName">
			 <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?>
		  	 </div>
			 <div style="margin-left:12px;width:150px;border-bottom:#f0f0f0 1px solid;"></div> 	 
	  	 </div>
		<h1 style="margin:0">Your fabulous Friends</h1>
		<div style="width:100%;height:10px;"></div>
		<?php
			require_once('config.php');
			$link=mysql_connect(HOST, USERNAME, PASSWORD) or die("Could not connect: " . mysql_error());
			$db=mysql_select_db(DATABASE,$link) or die("Could not connect: " . mysql_error());
	
			$qry="SELECT * FROM Users WHERE id IN (SELECT FriendID FROM Friends WHERE UserID = '".$_SESSION['SESS_MEMBER_ID']."')";
			$result=mysql_query($qry) or die(mysql_error());
			
			//Check whether the query was successful or not
			if($result) {
				while($row=mysql_fetch_assoc($result)){
					$name = $row['fname']." ".$row['lname']; 
					?>
					<div class="postNstuff">
						<img class="picture" src="<?php echo $row['ProfilePicAddress']; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" height="60px" />
						<span class="name"><?php echo $name; ?></span><br/>
						<span class="post"><?php echo $name." was born on ".$row['Birthday'].", but was last active on ".$row['LastActive']; ?></span>		
						<div style="width:100%;height:20px;"></div>
					</div>
					<?php
				}
			}
			else{echo "Sorry, you have no friends...";}
			mysql_close($link);
		?>
		
  	</div>
  
  </body>
</html>
