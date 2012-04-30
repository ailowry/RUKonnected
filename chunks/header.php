<div id="header">
 <a href="home.php"><img src="./imgs/logo.png" alt="RUConnected" border=0 /></a>
    <form id="friendfinder"onsubmit="makeFriendRequest(); return false;" >
        <input id="friendfinderinput" type="text" />
        <input id="friendrequestbutton" type="button"
            value="Send friend request" onclick="makeFriendRequest()" />
    </form>
     <span style="margin-top:10px;font-size:22px;color:#fff;float:right;margin-right:15px;">
    <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?> |
    <a href="./logout.php">Logout</a></span>
 
</div>
