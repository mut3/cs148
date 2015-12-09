<?php
	// include top
	include 'top.php';

	/* 
	Pantry (default) - View of current inventory
		All items or divided by location
		List should be able to be reordered by any category
		default order by status

	*/

	/*
	Remove items button
		brings up delete button on each record
	*/

	echo "<h2>Welcome to your Pantry</h2>";

	$startRec = 0;
	$numRec = 10;
	$startRec =(int) $_GET["startRecord"];
	$numRec =(int) $_GET["numRecord"];
	if ($startRec < 0){$startRec = 0;}
	$vars = "";
	$columns = 6;
	$query = "SELECT pmkItemId, fnkOwnerId, fldItemName, fldAmtTot, fldAmtRem, fldAmtUnit FROM tblItem WHERE fnkOwnerId = $userData[id] ORDER BY fldItemName LIMIT " . $startRec . "," . $numRec;
	$wheres = 1;
	$conditions = 1;
	$quotes = 0;
	$symbols = 0;

	echo '<a href="?numRecord=' . $numRec . '&startRecord=' . ($startRec - 10) . '"> Prev 10</a>';
	echo '<a href="?numRecord=' . $numRec . '&startRecord=' . ($startRec + 10) . '"> Next 10 </a>';

	
	// $thisDatabaseReader->testQuery($query, $vars, $wheres, $conditions, $quotes, $symbols);
	$info2 = $thisDatabaseReader->select($query, $vars, $wheres, $conditions, $quotes, $symbols);
	$headerFields = array_keys($info2[0]);
	// echo '<pre><p>';
	// print_r ($headerFields);
	// echo '</p></pre>';
	$headerArray = array_filter($headerFields, "is_string");
	// echo '<pre><p>';
	// print_r ($headerArray);
	// echo '</p></pre>';

	echo "<h2> Records: " . count($info2) . "</h2>";
	print '<table>';

	//header block
	print '<tr class="tblHeaders">';
	foreach ($headerArray as $key) {
		$camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
		$message = "";
		foreach ($camelCase as $one) {
			$message .= $one . " ";
		}
		print '<th>' . $message . '</th>';
	}
	print '</tr>';

	//data printed to table
	$highlight = 0; // used to highlight alternate rows
	foreach ($info2 as $rec) {
		$highlight++;
		if ($highlight % 2 != 0) {
			$style = ' odd ';
		} else {
			$style = ' even ';
		}
		print '<tr class="' . $style . '">';
		for ($i = 0; $i < $columns; $i++) {
			print '<td>' . $rec[$i] . '</td>';
		}
		print '</tr>';
	}
	print '</table>';
	// include top
	include 'bottom.php';
?>