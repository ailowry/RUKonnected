<?php
	require_once('auth.php');
?>
<html>
<head>
    <script type="text/javascript" src="./scripts/jquery-1.7.2.min.js">
    </script>
    <script type="text/javascript">
        function makeRequest() {
            var actionName = $('input[name=action]').val();
            var data = {action: actionName};
            if($('textarea[name=content]')) {
                data['content'] = $('textarea[name=content]').val();
            }
            if($('input[name=friendid]')) {
                data['friendid'] = $('input[name=friendid]').val();
            }
            if($('input[name=postid]')) {
                data['postid'] = $('input[name=postid]').val();
            }
            if($('input[name=time]')) {
                data['lastCall'] = $('input[name=time]').val();
            }
            $.post('api.php', data, function(res) {
                $('#response').text(res);
            });
        }
    </script>
</head>
<body>
    UserID: <?php echo $_SESSION['SESS_MEMBER_ID'] ?>
    <br>
    Username: <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'] ?>
    <br>
    <form name="input">
        Action:<input type="text" name="action"><br>
        FriendID:<input type="text" name="friendid"><br>
        PostID:<input type="text" name="postid"><br>
        Last Call:<input type="text" name="time"><br>
        Content:<textarea name="content"></textarea><br>
        <button type="button" onclick="makeRequest(); return false;">submit</button>
    </form>
    Response: <div id="response" style='background-color: lightBlue;'>---</div>
</body>
</html>
