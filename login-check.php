<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//$link=mysql_connect(HOST, USERNAME, PASSWORD) or die("Could not connect: " . mysql_error());
	//$db=mysql_select_db(DATABASE,$link) or die("Could not connect: " . mysql_error());
    require('./db.php');
	
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['user']);
	$password = clean($_POST['pass']);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM Users WHERE username='$login' AND password='".md5($_POST['password'])."'";
	$result=mysql_query($qry) or die(mysql_error());
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['fname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lname'];
			session_write_close();
			header("location: feed.php");
			exit();
		}else {
			//Login failed
			echo mysql_num_rows($result)."<br/>";
			echo md5($_POST['password'])."<br/>";
			echo md5($password)."<br/>";
			header("location: index.php");//make a fail/retry login page soon. 
			exit();
		}
	}else {
		die("Query failed");
	}
?>
	
