<?php //top
	// include top
	include 'top.php';


	/* 
	change or set user preferences
	form autofills current values if they exist
	*/
?>
<!--<?php // form validate and save data
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	// Variable initialization done in top
		//if there are values in the post
		if (isset($_POST["btnSubmit"])) {
		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2b Sanitize (clean) data
		// remove any potential JavaScript or html code from users input on the
		// form. Note it is best to follow the same order as declared in section 1c.
			if (!$newUser) {
				$update = true;
			}
			// I am not putting the ID in the $data array at this time

			$firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
			$data[] = $firstName;

			$lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
			$data[] = $lastName;

			$birthday = htmlentities($_POST["txtBirthday"], ENT_QUOTES, "UTF-8");
			$data[] = $birthday;

		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2c Validation
		//

			if ($firstName == "") {
				$errorMsg[] = "Please enter your first name";
				$firstNameERROR = true;
			} elseif (!verifyAlphaNum($firstName)) {
				$errorMsg[] = "Your first name appears to have extra character.";
				$firstNameERROR = true;
			}

			if ($lastName == "") {
				$errorMsg[] = "Please enter your last name";
				$lastNameERROR = true;
			} elseif (!verifyAlphaNum($lastName)) {
				$errorMsg[] = "Your last name appears to have extra character.";
				$lastNameERROR = true;
			}

			if ($birthday == "") {
				$errorMsg[] = "Please enter the poets birthday";
				$birthdayERROR = true;
			}// should check to make sure its the correct date format
		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2d Process Form - Passed Validation
		//
		// Process for when the form passes validation (the errorMsg array is empty)
		//
			if (!$errorMsg) {
				if ($debug) {
					print "<p>Form is valid</p>";
				}

		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2e Save Data
		//

				$dataEntered = false;
				try {
					$thisDatabase->db->beginTransaction();

					if ($update) {
						$query = 'UPDATE tblPoet SET ';
					} else {
						$query = 'INSERT INTO tblPoet SET ';
					}

					$query .= 'fldFirstName = ?, ';
					$query .= 'fldLastName = ?, ';
					$query .= 'fldBirthDate = ? ';

					if ($update) {
						$query .= 'WHERE pmkPoetId = ?';
						$data[] = $pmkPoetId;

						if ($_SERVER["REMOTE_USER"] == 'rerickso') {
							$results = $thisDatabase->update($query, $data, 1, 0, 0, 0, false, false);
						}
					} else {
						if ($_SERVER["REMOTE_USER"] == 'rerickso'){
							$results = $thisDatabase->insert($query, $data);
							$primaryKey = $thisDatabase->lastInsert();
							if ($debug) {
								print "<p>pmk= " . $primaryKey;
							}
						}
					}

					// all sql statements are done so lets commit to our changes
					//if($_SERVER["REMOTE_USER"]=='rerickso'){
					$dataEntered = $thisDatabase->db->commit();
					// }else{
					//     $thisDatabase->db->rollback();
					// }
					if ($debug)
						print "<p>transaction complete ";
				} catch (PDOExecption $e) {
					$thisDatabase->db->rollback();
					if ($debug)
						print "Error!: " . $e->getMessage() . "</br>";
					$errorMsg[] = "There was a problem with accepting your data please contact us directly.";
				}
			} // end form is valid
		} // ends if form was submitted.

?> -->
<?php // Page Content & Form
	echo "<p>Account settings of user: $username</p>";
	if ($newUser) {
		echo "<h2>New Account Setup</h2>";
		echo "<p>Please setup your account before attempting to use the site</p>";
	} else {
		echo "<h2>Account Settings</h2>";
	}



	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
?>
	<!-- Begin Form -->
	<form action="<?php print $phpSelf; ?>"
        method="post"
        id="frmRegister">

    <!-- Username/email -->
    <fieldset class="contact">
    	<label for="txtUsername">Username: <input type="text" id="txtUsername" name="username" value="<?php echo "$username"; ?>" readonly></label>
    	<label for="txtEmail">Email: <input type="email" id="txtEmail" name="email" value="<?php echo "$username" . '@uvm.edu'; ?>" readonly></label>
    </fieldset>
		<!-- SciFi Radio -->
	
		<fieldset class="radio">
		  <legend>Pick one:</legend>

		  <label for="radHitch">
		    <input type="radio" 
		           id="radHitch" 
		           name="radSciFi"
		           <?php if ($userData[sf]==0) {echo "checked";}?>
		           value="0">Don't Panic
		  </label>
		  
		  <label for="radSwars">
		    <input type="radio" 
		           id="radSwars" 
		           name="radSciFi"
		           <?php if ($userData[sf]==1) {echo "checked";}?> 
		           value="1">May the Force be with you
		  </label>

		  <label for="radTrek">
		    <input type="radio" 
		           id="radTrek" 
		           name="radSciFi"
		           <?php if ($userData[sf]==2) {echo "checked";}?> 
		           value="2">Live Long and Prosper
		  </label>

		</fieldset>
		<fieldset class="check">
			<label for="adminChk">
		    <input type="checkbox" 
		           id="adminChk" 
		           name="chkAdmin"
		           <?php if ($userData[admin]) {echo "checked readonly";}?>
		           value="Admin">Want to be an Admin?
		  </label>
		</fieldset>
		<fieldset class="buttons">
      <legend></legend>
      <input type="submit" id="btnSubmit" name="btnSubmit" value="Save" tabindex="900" class="button">
	  </fieldset>
	</form>
<?php //foot
	// include bottom
	include 'bottom.php';
?>