<pre>
<?php
	include_once('config.php');
	print_r($_POST);
	$link=mysql_connect(HOST, USERNAME, PASSWORD) or die("Could not connect: " . mysql_error());
	mysql_select_db(DATABASE,$link) or die("Could not connect: " . mysql_error());
	
	//md5('apples') = daeccf0ad3c1fc8c8015205c332f5b42  d41d8cd98f00b204e9800998ecf8427e
	$fnames = array('Tom','Bob','Claud','Joe','Sally','Alfred','Suesan','Cecil','Rob');
	$lnames = array('BackaFelli','Timjino','Cumbarsia','Lustadf','Rachmano','Norvell','Simmons');
	$randTime = date("Y-m-d H:i:s", mktime(0, 0, 0, rand(1,12), rand(1,29),rand(1992,2012)));
	//sizeof($array);
		
	for($i=0;$i<99;$i++){
		$f = $fnames[rand(0,sizeof($fnames)-1)];
		$l = $lnames[rand(0,sizeof($lnames)-1)];
		$randTime = date("Y-m-d H:i:s", mktime(0, 0, 0, rand(1,12), rand(1,29),rand(1992,2012)));
		
		$query="INSERT IGNORE INTO Users(username,password,email,fname,lname,Birthday,LastActive,ProfilePicAddress) ";
		$uname=substr($f,0,1).$l;
		$query.="VALUES('".$uname."','d41d8cd98f00b204e9800998ecf8427e','".$uname."@rnorvell.com','$f','$l','$randTime',NOW(),'http://www.rnorvell.com/projects/smile/smile.png')";
		echo $query."<br/>";	
		$result = mysql_query($query) or die("Could not execute: " . mysql_error());	
	}
/*
	$result = mysql_query("SELECT * FROM Users") or die("Could not connect: " . mysql_error());;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		printf("\nID: %s  Name: %s", $row["UserID"], $row["Username"]);
	}

	mysql_free_result($result);
*/
	mysql_close($link);
?>
</pre>
