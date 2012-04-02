<html>
	<head>
    	<style>
			body{margin:0;padding:0;}
			
			.header{
				width:100%;
				height:80px;
				background-color:#33F;
				margin:0;
				padding:0;
			}
			
			.header input{
				boarder:none;
				float:right;
				margin-top:20px;
				margin-right:15px;
				color:#cccccc;
			}
		</style>
    
    </head>

  <body>
   <form action="login-check.php" method="POST">
  	<div class="header" >
    	<input tabindex="3" type=submit name="submit" style="color:#000;" value="Login" />
        <input tabindex="2" onfocus="if (this.value=='Password') this.value = ''" type=password value="Password" name="pass" />   
        <input tabindex="1" onfocus="if (this.value=='Username') this.value = ''" type=text value="Username" name="user" />    
    </div>
   </form>
  </body>

</html>
