
<?php //takes in title & produces a header between <head> tags
function getHeader($title){
?>
<head>
	<title><?php echo $title; ?></title>
    	<style>
			body{margin:0;padding:0;font-type:"Verdana";}
			
			.header{
				width:100%;
				height:80px;
				background-color:#33F;
				margin:0;
				padding:0;
				color:#fff;
			}
			
			.header .userInfo{
				float:right;
				margin-right:10px;
				margin-top:50px;
				font-size:22px;
				font-weight:bold;
				color:#fff;
			}
			.header .userInfo a{color:#fff;}
			.header .userInfo a:hover{color:#fff;}
			.header .userInfo a:visited{color:#fff;}
			
			.header input{
				boarder:none;
				float:right;
				margin-top:20px;
				margin-right:15px;
				color:#cccccc;
			}
		</style>
    
</head>
<?php
}
?>