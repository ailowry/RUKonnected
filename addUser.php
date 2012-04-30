<pre>
<?php
	if($_POST){
		include_once('config.php');
		$link=mysql_connect(HOST, USERNAME, PASSWORD) or die("Could not connect: " . mysql_error());
		mysql_select_db(DATABASE,$link) or die("Could not connect: " . mysql_error());
		
		//md5('apples') = daeccf0ad3c1fc8c8015205c332f5b42  d41d8cd98f00b204e9800998ecf8427e
		$f=$_POST['f'];
		$l=$_POST['l'];
		$uname = $_POST['uname'];
		$pic = $_POST['pic'];
		$randTime = date("Y-m-d H:i:s", mktime(0, 0, 0, rand(1,12), rand(1,29),rand(1992,2012)));
		//sizeof($array);
		$randTime = date("Y-m-d H:i:s", mktime(0, 0, 0, rand(1,12), rand(1,29),rand(1992,2012)));
			$query="INSERT IGNORE INTO Users(username,password,email,fname,lname,Birthday,LastActive,ProfilePicAddress) ";
			$query.="VALUES('".$uname."','d41d8cd98f00b204e9800998ecf8427e','".$uname."@radford.com','$f','$l','$randTime',NOW(),'".$pic."')";
			echo $query."<br/>";	
			$result = mysql_query($query) or die("Could not execute: " . mysql_error());	
		
	/*
		$result = mysql_query("SELECT * FROM Users") or die("Could not connect: " . mysql_error());;

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			printf("\nID: %s  Name: %s", $row["UserID"], $row["Username"]);
		}

		mysql_free_result($result);
	*/
		mysql_close($link);
		echo "success";
	}
?>
</pre>
<form action="addUser.php" method="POST">
Username<input type=text name=uname /><br/>
First Name<input type=text name=f /><br/>
Last Name<input type=text name=l /><br/>
Pic Address<input type=text name=pic value="http://sprouter.com/images/users/default_user_large.png?1332876384"/><br/>
<input type=submit name=submit /><br/>
</form>
