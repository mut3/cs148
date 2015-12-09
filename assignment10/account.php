<?php //top
	// include top
	include 'top.php';


	/* 
	change or set user preferences
	form autofills current values if they exist
	*/
?>
<?php // form engine
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// Variable initialization done in top
	//if there are values in the post


?>
<?php // Page Content & Form
	echo "<p>Account settings of user: $username</p>";
	if ($newUser) {
		echo "<h2>New Account Setup</h2>";
		echo "<p>Please setup your account before attempting to use the site</p>"
	} else {
		echo "<h2>Account Settings</h2>";
	}
?>
<?php //foot
	// include bottom
	include 'bottom.php';
?>