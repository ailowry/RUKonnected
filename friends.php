<?php
  require_once('auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>
      <?php require('chunks/scripts.php'); ?>
      <script type="text/javascript">
        $(document).ready(function() {
          generatePossibleFriends(); 
          populateFriendsList();
        });
      </script>
		<title>RUConnected | My Friends</title>
	</head>
  <body>
    <?php require('chunks/header.php');?>	
  	<div id="content">
      <?php require('chunks/leftbar.php');?>
    <div class="rightbar">
		<h1 style="margin:0; padding:5px 5px 5px 5px;">Your fabulous Friends</h1>
		<?php require_once('config.php');
			$link=mysql_connect(HOST, USERNAME, PASSWORD) or die("Could not connect: " . mysql_error());
			$db=mysql_select_db(DATABASE,$link) or die("Could not connect: " . mysql_error());
	
			$qry="SELECT * FROM Users WHERE id IN (SELECT FriendID FROM Friends WHERE UserID = '".$_SESSION['SESS_MEMBER_ID']."')";
			$result=mysql_query($qry) or die(mysql_error());
			
			//Check whether the query was successful or not
			if($result) {
				while($row=mysql_fetch_assoc($result)){
					$name = $row['fname']." ".$row['lname']; 
					?>
					<div class="mainpost">
						<img class="postprofileimg" src="<?php echo $row['ProfilePicAddress']; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" height="60px" />
						<span class="commentdisplayname"><h3><?php echo $name; ?></h3></span><br/>
						<span class="postcontent"><?php echo $name." was born on ".$row['Birthday'].", but was last active on ".$row['LastActive']; ?></span>		
						<span style="width:100%;height:20px;"></span>
					</div>
					<?php
				}
			}
			else{echo "Sorry, you have no friends...";}
			mysql_close($link);
		?>
		</div>
  	</div>
  </body>
</html>
