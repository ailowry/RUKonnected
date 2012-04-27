<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	ini_set('display_errors',true); 
	ini_set('display_startup_errors',true); 
	error_reporting (E_ALL|E_STRICT);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="myStyle.css"/>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<title>RUConnected</title>
<style type="text/css">
	.error
	{
		color: red;
		font-weight: bold;
	}
</style>

<script type="text/javascript">
	function validateEmail ()
	{
		var mailToCheck = document.forms["registration"]["email"].value;
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)([a-zA-Z0-9]{2,4})+$/;
		var atPos = mailToCheck.indexOf("@");
		var dotPos = mailToCheck.indexOf(".");
		if (atPos<1 || dotPos<atPos+2 || dotPos+2>=atPos.length || !filter.test(mailToCheck))
		{
			alert("Not A Valid Email Address");
		}
	}
	
	function validateName()
	{
		var nameToCheck = document.forms["registration"]["usrname"].value;
		var match = /[^A-Za-z0-9 \-]+/.test(nameToCheck);
		if (nameToCheck.length < 5 || nameToCheck == "" || nameToCheck == null || match == true)
		{
			alert("Not A Valid User Name");
		}
	}
	
	function validatePwd1()
	{
		var pwdToCheck1 = document.forms["registration"]["pwd1"].value;
		var match1 = /[^A-Za-z0-9]+/.test(pwdToCheck1);
		if (pwdToCheck1 !== null || pwdToCheck1 !== "")
		{
			if (match1 === true)
			{
				alert("Invalid Password");
			}
		}
	}
	
	function validatePwd2()
	{
		var pwdToCheck1 = document.forms["registration"]["pwd1"].value;
		var pwdToCheck2 = document.forms["registration"]["pwd2"].value;
		var match2 = /[^A-Za-z0-9]+/.test(pwdToCheck2);
		if (pwdToCheck2 !== null || pwdToCheck2 !== "")
		{
			if (match2 === true || pwdToCheck1 !== pwdToCheck2)
			{
				alert("Invalid Password");
			}
		}
	}
</script>
</head>
<?php
	$errMsgs = array();
	if( array_key_exists('i-came-from-form',$_POST) ){	
		$namePat = '/[[:alnum:]]/';
		$validName= preg_match($namePat, $_POST["usrname"]);
		if (empty($_POST['usrname']) || $validName == 0)
		{
			$errMsgs['usrname'] = 'Invalid Name.';
		}
		
		$mailPat = '/^([a-zA-Z0-9\.\-])+\@(([a-zA-Z0-9\-])+\.)([[:alnum:]]{2,4})+$/';
		$validMail=preg_match($mailPat,$_POST["email"]);
		if ($validMail == 0)
		{
			$errMsgs['email'] = "Invalid Email.";
		}
		
		if ($_POST['gender'] !== 'male' && $_POST['gender'] !== 'female')
		{
			$errMsgs['gender'] = 'Gender Not Set.';
		}
		
		$validPwd1 = preg_match($namePat,$_POST['pwd1']);
		if ($validPwd1 == 0)
		{
			$errMsgs['pwd1'] = 'Invalid Password.';
		}
		
		$validPwd2 = preg_match($namePat,$_POST['pwd2']);
		if ($validPwd2 == 0)
		{
			$errMsgs['pwd2'] = 'Invalid Password.';
		}
		if ($_POST['pwd1'] !== $_POST['pwd2'])
		{
			$errMsgs['pwd2'] = 'Passwords Do Not Match';
		}
	}	
		$formIsValid = array_key_exists('i-came-from-form',$_POST) && !$errMsgs;
?>

<body>
	<div id="header">
    <span class="logo">RU<em><span class="ru">Connected</span></em></span>
			<input type="button" name="friendrequests" value="Friend Requests" />
			<input type="button" name="messages" value="Messages" />
			<input type="button" name="notifications" value="Notifications" />
			<a href="logout" name="logout" />Logout</a>
  </div>
  <div id="container">
    <div id="leftcol">
      &nbsp;			
    </div>
    <div id="content">
			<form action="regform.php" method="post" name="registration">
            	<table>
                	<tr>
                    	<td>E-Mail: </td>
                    	<td>
                        	<input type="text" name="email" onblur="validateEmail()" size="20"
							value="<?php
									if(isset($_POST['email']))
									{
										echo htmlspecialchars($_POST['email']);
									} ?>" />
                        </td>
						<td class="error">
							<?php
								if(isset($errMsgs['email']))
								{
									echo $errMsgs['email'];
								}
							?>
						</td>
                    </tr>
                    <tr>
                    	<td>User Name: </td>
                        <td>
							<input type="text" name="usrname" onblur="validateName()" size="20"
							value="<?php if (isset($_POST['usrname'])){
								echo htmlspecialchars($_POST['usrname']);}
							?>" />
						</td>
						<td class="error">
							<?php
								if(isset($errMsgs['usrname']))
								{
									echo $errMsgs['usrname'];
								}
							?>
						</td>
                    </tr>
                    <tr>
                    	<td>Gender: </td>
                        <td>
                        	<select name="gender"
									value="<?php if (isset($_POST['gender'])){
									echo htmlspecialchars($_POST['gender']);}?>">
                            	<option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </td>
						<td class="error">
							<?php
								if(isset($errMsgs['gender']))
								{
									echo $errMsgs['gender'];
								}
							?>
						</td>
                    </tr>
                    <tr>
                    	<td>Password: </td>
                        <td>
							<input type="password" name="pwd1" onblur="validatePwd1()" size="20" />
						</td>
						<td class="error">
							<?php
								if(isset($errMsgs['pwd1']))
								{
									echo $errMsgs['pwd1'];
								}
							?>
						</td>
                    </tr>
                    <tr>
                    	<td>Confirm Password: </td>
                        <td>
							<input type="password" name="pwd2" onblur="validatePwd2()" size="20" />
						</td>
						<td class="error">
							<?php
								if(isset($errMsgs['pwd2']))
								{
									echo $errMsgs['pwd2'];
								}
							?>
						</td>
                    </tr>
                    <tr>
                    	<td><input type="submit" value="Submit" /></td>
                        <td><input type="reset" value="Clear Form" /></td>
                    </tr>
                </table>
				<input type="hidden" name="i-came-from-form" value="true" />
            </form>
    </div>
	</div>
</body>
</html>