<?php
include "lib/constants.php";
require_once('lib/custom-functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Pantry Raid</title>
	<meta charset="utf-8">
	<meta name="author" content="Will Barnwell wwbarnwell (at) gmail (dot) com">
	<meta name="description" content="A website edited for an assignment by a smartass college kid who thinks of himself as pretty funny.">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
	<![endif]-->

	<link rel="stylesheet" href="css/base.css" type="text/css" media="screen">

	<?php
		$debug = false;

		// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
		//
		// inlcude all libraries. Note some are in lib and some are in bin
		// bin should be located at the same level as www-root (it is not in 
		// github)
		// 
		// yourusername
		//     bin
		//     www-logs
		//     www-root
		
		$includeDBPath = "../bin/";
		$includeLibPath = "../lib/";
		
		
		require_once($includeLibPath . 'mailMessage.php');

		require_once('lib/security.php');
		
		require_once($includeDBPath . 'Database.php');
		
		// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
		//
		// PATH SETUP
		//  
			
		// sanitize the server global variable
		$_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
		foreach ($_SERVER as $key => $value) {
			$_SERVER[$key] = sanitize($value, false);
		}
		
		$domain = "//"; // let the server set http or https as needed

		$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

		$domain .= $server;

		$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

		$path_parts = pathinfo($phpSelf);

		if ($debug) {
			print "<p>Domain" . $domain;
			print "<p>php Self" . $phpSelf;
			print "<p>Path Parts<pre>";
			print_r($path_parts);
			print "</pre>";
		}
		
		$yourURL = $domain . $phpSelf;

		$absDirPath = "https:" . $domain . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

		$pageName = (basename($_SERVER["SCRIPT_FILENAME"]));


		echo "$pageName";
		// echo "$absDirPath";
		

		// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
		// sanatize global variables 
		// function sanitize($string, $spacesAllowed)
		// no spaces are allowed on most pages but your form will most likley
		// need to accept spaces. Notice my use of an array to specfiy whcih 
		// pages are allowed.
		// generally our forms dont contain an array of elements. Sometimes
		// I have an array of check boxes so i would have to sanatize that, here
		// i skip it.

		$spaceAllowedPages = array("restock.php", "use.php");

		if (!empty($_GET)) {
			$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
			foreach ($_GET as $key => $value) {
				$_GET[$key] = sanitize($value, false);
			}
		}
		
		// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
		//
		// Process security check.
		//
		
		if (!securityCheck($path_parts, $yourURL)) {
			print "<p>Login failed: " . date("F j, Y") . " at " . date("h:i:s") . "</p>\n";
			die("<p>Sorry you cannot access this page. Security breach detected and reported</p>");
		}

		// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
		//
		// Set up database connection
		//
		
		$dbUserName = get_current_user() . '_reader';
		$whichPass = "r"; //flag for which one to use.
		$dbName = DATABASE_NAME;

		$thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);
		
		$dbUserName = get_current_user() . '_writer';
		$whichPass = "w";
		$thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);
		
		$dbUserName = get_current_user() . '_admin';
		$whichPass = "a";
		$thisDatabaseAdmin = new Database($dbUserName, $whichPass, $dbName);



		// *********&*&*&*&*&&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&**&*
		$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");

		$redirTarget = $absDirPath . "/account.php";
		// query user table for record of this user
		$UQquery = "SELECT pmkUserId, fldUsername, fldEmail, fldAdmin FROM tblUser WHERE fldUsername = 'adatta'";
		$UQvars = "";
		$UQwheres = 1;
		$UQconditions = 0;
		$UQquotes = 2;
		$UQsymbols = 0;
		// $thisDatabaseReader->testQuery($query, $vars, $wheres, $conditions, $quotes, $symbols);
		$userRecord = $thisDatabaseReader->select($UQquery, $UQvars, $UQwheres, $UQconditions, $UQquotes, $UQsymbols);
		// echo "<pre>";
		// print_r($userRecord);
		// echo "</pre>";

		//place first record array into var
		$firstRecord = $userRecord[0];
		// echo count($userRecord);
		if (/*no record exists for user*/ false && $pageName != "account.php") {
		 	//if no data for user
		 	//re-direct to account.php
			echo "<meta http-equiv=\"refresh\" content=\"0;url=$redirTarget\">";
		} 
		//load up userdata for user
		$userData = array(
			"id" => $firstRecord[pmkUserId],
			"username" => $username,
			"email" => $firstRecord[fldEmail],
			"admin" => $firstRecord[fldAdmin],
			"sf" => $firstRecord[fldSciFi]
		);
		var_dump($userData);
	?>	

</head>



<!-- **********************     Body section      ********************** -->
<?php
	include 'nav.php';
	print '<body id="' . $path_parts['filename'] . '">';
	include "header.php";
	include "nav.php";

	$headerFields = array_keys($userRecord[0]);
    // echo '<pre><p>';
    // print_r ($headerFields);
    // echo '</p></pre>';
    $headerArray = array_filter($headerFields, "is_string");
    // echo '<pre><p>';
    // print_r ($headerArray);
    // echo '</p></pre>';

    echo "<h2> Records: " . count($userRecord) . "</h2>";
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
    foreach ($userRecord as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < 4; $i++) {
            print '<td>' . $rec[$i] . '</td>';
        }
        print '</tr>';
    }
    print '</table>';
?>