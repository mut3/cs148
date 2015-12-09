<?php //top
	// include top
	include 'top.php';


	/* 
	change or set user preferences
	form autofills current values if they exist
	*/
?>
<?php // form validate and save data
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	// Variable initialization done in top
		//if there are values in the post
		if (isset($_POST["btnSubmit"])) {
			update = false;
			if (!$newUser) {
				$update = true;
			}
		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2b Sanitize (clean) data
		// remove any potential JavaScript or html code from users input on the
		// form. Note it is best to follow the same order as declared in section 1c.
		

		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2c Validation
		//
			$sciFiERROR = false;
			if ($radSciFi == "") {
				$errorMsg[] = "Please pick a Science Fiction quote";
				$sciFiERROR = true;
			} 
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
					$thisDatabaseWriter->db->beginTransaction();

					if ($update) {
						$query = 'UPDATE tblUser SET ';
					} else {
						$query = 'INSERT INTO tblUser SET ';
					}
					
					$query .= 'fldUsername = ?, ';
					$data[] = $userData[username];
					$query .= 'fldEmail = ?, ';
					$data[] = $_POST['email'];
					$query .= 'fldSciFi = ?, ';
					$data[] = $_POST['radSciFi'];
					$query .= 'fldAdmin = ? ';
					// now comes the super annoying Admin bit
					$updateRecId = "";
					$wannabe = false;
					// not set? false
					if (!isset($_POST['chkAdmin'])) {
						$data[] = false;
					} elseif ($userData['admin']) {
						//already an admin? true
						$data[] = true;
					} else {
						//otherwise we have to ask the Admin table
						$admQuery = "SELECT pmkAdminId, fnkUserId, fldUsername FROM tblAdmin";
						$admResults = $thisDatabaseReader->select($admQuery);
						foreach ($admResults as $row) {
							if($row[fldUsername]==$username) {
								// get the record we need to update, we'll use this later
								$updateRecId = $row[pmkAdminId];
								break;
							}
						}
						if ($updateRecId != "") {
							$data[] = true;
						} else {
							$data[] = false;
							$wannabe = true;
						}
					}
					$primaryKey = "";
					if ($update) {
						$query .= 'WHERE pmkUserId = ?';
						$data[] = $userData[id];
						$results = $thisDatabaseWriter->update($query, $data, 1, 0, 0, 0, false, false);
						$primaryKey = $userData['id'];
						
					} else {
						$results = $thisDatabaseWriter->insert($query, $data);
						$primaryKey = $thisDatabaseReader->lastInsert();
						if ($debug) {
							print "<p>pmk= " . $primaryKey;
						}
					}
					if ($updateRecId != "") {
						//gotta update the admin database to point the fnk to the right place
						$adUpQuery = "UPDATE tblAdmin SET fnkUserId = $primaryKey WHERE pmkAdminId = $updateRecId";
						$thisDatabaseWriter->update($adUpQuery, "", 1, 0, 0, 0, false, false);
					}
					if ($wannabe) {
						// if they didnt make the cut add them to the sad place
						$wnbQuery = "INSERT INTO tblWannabeAdmin (fnkLuserId) VALUES ($primaryKey)";
						$thisDatabaseWriter->insert($wnbQuery, "", 1, 0, 0, 0, false, false);
					}

					// all sql statements are done so lets commit to our changes
					//if($_SERVER["REMOTE_USER"]=='rerickso'){
					$dataEntered = $thisDatabaseWriter->db->commit();
					// }else{
					//     $thisDatabaseWriter->db->rollback();
					// }
					if ($debug)
						print "<p>transaction complete ";
				} catch (PDOExecption $e) {
					$thisDatabaseWriter->db->rollback();
					if ($debug)
						print "Error!: " . $e->getMessage() . "</br>";
					$errorMsg[] = "There was a problem with accepting your data please contact us directly.";
				}
			} // end form is valid
		} // ends if form was submitted.

?>
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
	
		<fieldset class="radio <?php if ($sciFiERROR) {print 'mistake';}?>">
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