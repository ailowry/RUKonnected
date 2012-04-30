<?php
  require_once('auth.php');
  require_once('util.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
        <link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />
        <?php require("chunks/scripts.php"); ?> 
        <script type="text/javascript" src="./scripts/feed.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                startApp();
            });
        </script>

    <title>RUConnected | Home</title>
  
  </head>
  
  <body>
    <?php require("chunks/header.php"); ?>  
    <div id="content">
         <?php require("chunks/leftbar.php"); ?>
         <div class="rightbar">
             <form id="postform" class="commentform" style="height:32px;">
                <input name="content" onfocus="if(this.value=='Make new post') {
                    this.value = ''}" value="Make new post" size=85 style="margin-left:20px;height:2em;"/>
                <input type="button" value="Make Post" onclick="makePost($(this).parent())">
             </form>
             <div class="postarea">
             </div>
         </div>
         <div class="clear"></div>
         <div class="alert" style="display:none"></div>
    </div>
  </body>
</html>
