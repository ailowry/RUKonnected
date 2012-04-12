<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    require('./auth.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="RUCstyles.css"/>
<title>RUConnected - Login</title>
<script type="text/javascript" src="./scripts/jquery-1.7.2.min.js">
</script>
<script type="text/javascript" src="./scripts/mustache.js">
</script>
<script type="text/javascript" src="./scripts/feed.js">
</script>
</head>

<body>
	<!-- Header division with table containing main title and login form -->
    <div class="header">
    	<form name="login" action="#" method="post">
        	<table width="100%" cellpadding="5px">
        		<tr>
        			<td width="270px"><h1>R.U. Connected</h1></td>
            	</tr>
			</table>
        </form>
	</div>
    
    <!-- main container div to hold 2-3 columns of information -->
<div class="container">
    	<!-- Left Sidebar div to contain personal information or simple image display; floated to the left -->
        <div class="leftSB">
        <!-- Table to display user profile information -->
        <table>
        	<tr>
            	<td colspan="2"><img alt="Client Photo Here" name="myPhoto" width="100" height="100" style="background-color: #FF0000" /><br/></td>
            </tr>
        	<tr>
            	<td>Name: </td>
                <td><?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'] ?></td>
            </tr>
            <tr>
            	<td>Age: </td>
                <td>$userAge</td>
            </tr>
            <tr>
            	<td>Location: </td>
                <td>$location</td>
            </tr><tr>
            	<td>Mood: </td>
                <td>$mood</td>
            </tr>
        </table>
            <br />
<ul class="nav">
            	<li><a href="#">R.U. Wall</a></li>
                <li><a href="#">Notes</a></li>
                <li><a href="#">Images</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
</div>
        
        <!-- Right Sidebar div to contain future functionality such as search or grouping functions; floated to the right -->
        <div class="rightSB">
        	<p>This column will contain a variety of later functionality ranging from ad-space to a search box for finding specific users to grouping tools enabling the user to find similar names or interests quickly.</p>
        </div>
        
<!-- Main content div -->
        <div class="content">
        	<h2>Welcome to R.U. Connected $userName!</h2>
            <h3>The R.U. Wall</h3>
            <hr />
            <form class="postform">
                <textarea name="content" onclick="this.value = ''; this.onclick=null;">Post here</textarea><br>
                <button type="button" onclick="makePost(this.form); return false;">submit</button>
            </form>
            <div class="postarea">
          </div>
		  <div class="footer">Created by Brad Haga for the ARAS Group on 04/06/2012</div>
      </div>
    </div>
</body>
</html>
