<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css"/>

    <title>RUConnected</title>
  </head>
  <body>
    <?php require("chunks/guestHeader.php"); ?>
    <div id="contentindex">
       <div class="login-box">
        <span>Welcome to RUConnected!</span><br />
        <form action="login-check.php" method="POST">
            <input tabindex="1" onfocus="if(this.value=='Username') this.value = ''"
                type="text" value="Username" name="user" />
            <input tabindex="2" onfocus="if(this.value=='Password') this.value = ''"
                type="password" value="Password" name="pass" /><br/>
            <input tabindex="3" type="submit" name="submit"
                style="color:#000;width:100px;" value="Login" /><br/>
      </form>
     </div>
    <br />
    - OR -
    <br /><br />
    <a href="regform.php">Register</a>
    <br /><br />
    </div>
  </body>
</html>
