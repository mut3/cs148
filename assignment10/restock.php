<?php
	// include top
	include 'top.php';

	/* 
	(Re)Stock- Form to Add or Increase amounts of Items
		On form submission report back levels of each item added

	*/
?>
<?php // load units and items
	$units = array("cups","pounds","tbsp","tsp");
	$itemQuery = "SELECT pmkItemId, fnkOwnerId, fldItemName, fldAmtTot, fldAmtRem, fldAmtUnit FROM tblItem WHERE fnkOwnerId = $userData[id]";
	$itemResults = $thisDatabaseReader->select($itemQuery, "", 1);
	$itemRef = array();
	foreach ($itemResults as $row) {
		$itemRef[$row[pmkItemId]] = $row[fldItemName];
	}
?>
<?php // form validate and save data
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	// Variable initialization
	$newItemName = "";
	$extItemId = "";
	$amtTot = "";
	$amtRem = "";
	$amtUnit = "";
	$itemName ="";
	// echo sanitize("this is a test", true);
		//if there are values in the post
		if (isset($_POST["btnSubmit"])) {
		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2b Sanitize (clean) data
		// remove any potential JavaScript or html code from users input on the
		// form. Note it is best to follow the same order as declared in section 1c.
			// I am not putting the ID in the $data array at this time

			$newItemName = htmlentities($_POST["newItemName"], ENT_QUOTES, "UTF-8");

			$extItemId = htmlentities($_POST["extItemId"], ENT_QUOTES, "UTF-8");
			
		//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		//
		// SECTION: 2c Validation
		//

			if ($newItemName == "" && $extItemId == "") {
				$errorMsg[] = "Please enter or select an item name";
				$itemERROR = true;
			}

			if ($amtTot == "") {
				$errorMsg[] = "Please enter the amount (total)";
				$amtTotERROR = true;
			}

			if ($amtUnit == "") {
				$errorMsg[] = "Please select a unit";
				$amtUnitERROR = true;
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
					$thisDatabase->db->beginTransaction();
					if ($extItemId != "") {
						$update = true;
					}
					if ($update) {
						$query = 'UPDATE tblItem SET ';
						$itemName = $itemRef[$extItemId];
					} else {
						$query = 'INSERT INTO tblItem SET ';
					}

					if (!$update) {
						$query .= 'fldItemName = ?, ';
						$data[] = $newItemName;
						$query .= 'fnkOwnerId = ?, ';
						$data[] = $userData['id'];
					}
					$query .= 'fldAmtTot = ?, ';
					$data[] = $amtTot;
					$query .= 'fldAmtRem = ?, ';
					$data[] = $amtRem;
					$query .= 'fldAmtUnit = ? ';
					$data[] = $amtUnit;

					if ($update) {
						$query .= 'WHERE pmkItemId = ?';
						$data[] = $extItemId;

						$results = $thisDatabase->update($query, $data, 1, 0, 0, 0, false, false);
						
					} else {
						
						$results = $thisDatabase->insert($query, $data);
						$primaryKey = $thisDatabase->lastInsert();
						!itemName = $newItemName
						if ($debug) {
							print "<p>pmk= " . $primaryKey;
						}
					}

					// all sql statements are done so lets commit to our changes
					//if($_SERVER["REMOTE_USER"]=='rerickso'){
					$dataEntered = $thisDatabase->db->commit();
					$successMessage = "Successfully stocked " . $itemName;
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
<?php
	//display errors
	if ($errorMsg) {
    print '<div id="errors">';
    print "<ol>\n";
    foreach ($errorMsg as $err) {
        print "<li>" . $err . "</li>\n";
    }
    print "</ol>\n";
    print '</div>';
  }
?>
<form action="<?php print $phpSelf; ?>"
      method="post"
      id="frmRestock">
	<!-- Item Name - text Entry= new, drop down = update -->
	<fieldset class="itemName">
		<legend>Either enter a new item name or choose an existing item to update</legend>
		<label for="txtItemName">New Item Name: <input type="text" id="txtItemName" name="newItemName" value="<?php echo "$newItemName"; ?>"></label>
		<label for="sltItemName"> or: 
			<select id="sltItemName" name="extItemId" size="5">
				<option <?php echo ($extItemId == "") ? "selected" : ""; ?>>Select an existing item...</option>
				<?php
					foreach ($itemResults as $rec) {
						echo "<option value=" . $rec[pmkItemId] . " " . ($extItemId == $rec[pmkItemId]) ? "selected" : "" . ">" . $rec[fldItemName] . "</option>";
					}
				?>
			</select>
		</label>

	</fieldset>
	<!-- Amount Total - numerical text entry and units drop down -->
	<fieldset class="amount">
		<legend>How much do you have? Select a unit</legend>
		<label for="txtAmtTot">Amount (Total): <input type="number" id="txtAmtTot" name="amtTot" min="0" step=".1" max="100" value="<?php echo "$amtTot"; ?>"></label>
		<!-- Amount Remaining (opt) - numerical text entry and units drop down -->
		<legend>Already used some?</legend>
		<label for="txtAmtRem">Amount (Remaining): <input type="number" id="txtAmtRem" name="amtRem" min="0" step=".1" max="100" value="<?php echo "$amtRem"; ?>"></label>
		<label for="sltAmtUnit"> Units: 
			<select id="sltAmtUnit" name="amtUnit" size="5">
				<option <?php echo ($amtUnit == "") ? "selected" : ""; ?>>Select Unit...</option>
				<?php
					foreach ($units as $unit) {
						echo "<option value=" . $unit . " " . ($amtUnit == $unit) ? "selected" : "" . ">" . $unit . "</option>";
					}
				?>
			</select>
		</label>
	</fieldset>
	<fieldset class="buttons">
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Stock it!" tabindex="900" class="button">
  </fieldset>
</form>
<?php
	// include bottom
	include 'bottom.php';
?>