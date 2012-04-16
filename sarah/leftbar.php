<div class="leftbar">
	<?php 
		echo "<img width=150px src='".$_SESSION['SESS_PICTURE']."' alt='' />";
		echo "<p>" . $_SESSION['SESS_FIRST_NAME']." " . $_SESSION['SESS_LAST_NAME'] . "<br />" 
				. "<strong>Professor:</strong> Computer Science<br />" 
				. "<a href='mailto:" . $_SESSION['SESS_EMAIL'] . "'>" . $_SESSION['SESS_EMAIL'] . "</p>"; 
	?>
	<br />
</div>