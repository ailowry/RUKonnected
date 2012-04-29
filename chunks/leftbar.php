<div class="leftbar">
     <?php echo "<img width=150px src='".$_SESSION['SESS_PICTURE']."' alt='' />"; ?>
     <br/>
     <div class="UsersName">
     <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']; ?>
     </div>
     <div style="margin-left:12px;width:150px;border-bottom:#f0f0f0 1px solid;"></div> 	
     <div style="margin-left:10px;margin-top:7px;">
        <ul>
            <li>
                <a style="text-decoration:none;" href="friends.php">Your Friends</a>
            </li>
            <li>
                <a style="text-decoration:none;" href="messages.php">Messages</a>
            </li>
        </ul>
     </div>
 </div>
