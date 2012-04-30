<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<title>RUConnected | Registration</title>
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
				alert("Passwords do not match");
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
        if($_POST['fname'] == '') {
			$errMsgs['fname'] = 'First name is invalid';
        }
        if($_POST['lname'] == '') {
			$errMsgs['lname'] = 'Last name is invalid';
        }
	}	
		$formIsValid = array_key_exists('i-came-from-form',$_POST) && !$errMsgs;
    if($formIsValid) {
        require_once('config.php');

        $link=mysql_connect(HOST, USERNAME, PASSWORD)
            or die("Could not connect: " . mysql_error());
        $db=mysql_select_db(DATABASE,$link)
            or die("Could not connect: " . mysql_error());
        $username_v = mysql_real_escape_string($_POST['usrname']);
        $password_v = md5($_POST['pwd1']);
        $fname_v = mysql_real_escape_string($_POST['fname']);
        $lname_v = mysql_real_escape_string($_POST['lname']);
        $email_v = mysql_real_escape_string($_POST['email']);
        $qStr = "INSERT INTO Users(username, password, fname, lname, BirthDay, ProfilePicAddress, email) "
            . "VALUES('$username_v', '$password_v', '$fname_v', '$lname_v', '1987-05-24', 'http://www.rnorvell.com/projects/smile/smile.png', '$email_v')";
        $success = mysql_query($qStr);
        if($success) {
			header("location: regsuccess.php");
        }
        else {
            $flash = mysql_error();
        }
    }
?>

<body>
    <?php require("chunks/guestHeader.php"); ?>
  <div id="content">
      <div class="regform">
			<form action="regform.php" method="post" name="registration">
              <table>
              <caption><strong>Registration Form</strong></caption>
                    <tr>
                    	<td>User Name: </td>
                        <td>
							<input type="text" name="usrname" onblur="if(this.value != '') validateName()" size="20"
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
                    <tr><td colspan="2"><hr></td></tr>
                	<tr>
                    	<td>First Name: </td>
                    	<td>
                        	<input type="text" name="fname"  size="20"
							value="<?php
									if(isset($_POST['fname']))
									{
										echo htmlspecialchars($_POST['fname']);
									} ?>" />
                        </td>
						<td class="error">
							<?php
								if(isset($errMsgs['fname']))
								{
									echo $errMsgs['fname'];
								}
							?>
						</td>
                    </tr>
                	<tr>
                    	<td>Last Name: </td>
                    	<td>
                        	<input type="text" name="lname"  size="20"
							value="<?php
									if(isset($_POST['lname']))
									{
										echo htmlspecialchars($_POST['lname']);
									} ?>" />
                        </td>
						<td class="error">
							<?php
								if(isset($errMsgs['lname']))
								{
									echo $errMsgs['lname'];
								}
							?>
						</td>
                    </tr>
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
                      <td></td>
                    	<td><input type="submit" value="Submit" style="width:80px"/>&nbsp;
                        <input type="reset" value="Clear Form" style="width:80px"/></td>
                    </tr>
                </table>
				<input type="hidden" name="i-came-from-form" value="true" />
            </form>
    </div>
    </div>
</body>
</html>
