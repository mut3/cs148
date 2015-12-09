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
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
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


		// echo "$pageName";
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
		$UQquery = "SELECT pmkUserId, fldUsername, fldEmail, fldSciFi, fldAdmin FROM tblUser WHERE fldUsername = '$username'";
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
		//load up userdata for user
		$userData = array(
			"id" => $firstRecord[pmkUserId],
			"username" => $username,
			"email" => $firstRecord[fldEmail],
			"sf" => $firstRecord[fldSciFi],
			"admin" => $firstRecord[fldAdmin]
		);
		// echo "<p>dbg: User data: "; var_dump($userData);
		// echo count($userRecord);
		$newUser = false;
		if ($userData[id] == NULL) {
			// echo "<p>dbg: newUser triggered " . $userData[id];
		 	//if no data for user
		 	$newUser = true;
		 	//re-direct to account.php
		 	if (($pageName != "account.php")&&($pageName != "about.php")) {
				echo "<meta http-equiv=\"refresh\" content=\"0;url=$redirTarget\">";
		 	}
		 	
		} 
		// var_dump($userData);
	?>	

</head>



<!-- **********************     Body section      ********************** -->
<?php
	include 'nav.php';
	print '<body id="' . $path_parts['filename'] . '">';
	include "header.php";
	include "nav.php";
?>