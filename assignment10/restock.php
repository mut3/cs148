<?php
	// include top
	include 'top.php';

	/* 
	(Re)Stock- Form to Add or Increase amounts of Items
		On form submission report back levels of each item added

	*/
?>
<?php // form validate and save data
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

?> 
<!-- Form -->
<form action="<?php print $phpSelf; ?>"
      method="post"
      id="frmRestock">
	<!-- Item Name - text Entry= new, drop down = update -->
	<!-- Amount Total - numerical text entry and units drop down -->
	<!-- Amount Remaining (opt) - numerical text entry and units drop down -->
<?php
	// include bottom
	include 'bottom.php';
?>