<div id="header">
		<img src="./imgs/RUConnected_Logo.png" alt="RUConnected Logo" />
		<input type="button" name="friendrequests" value="Friend Requests" />
		<input type="button" name="messages" value="Messages" />
		<input type="button" name="notifications" value="Notifications" />
		<span><?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="./logout.php">Logout</a></span>
</div>