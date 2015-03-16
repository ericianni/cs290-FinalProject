<?php
	/**
	 * Contians all the information needed to access the database and tables.
	 * Also initializes a mysqli object for use by each page.
	 */

	session_start();
	$host = "oniddb.cws.oregonstate.edu";
	$user = "iannie-db";
	$pwd = "6kRBxp0O6k2hf4rb";
	$databaseName = "iannie-db";
	$mysqli = new mysqli($host, $user, $pwd, $databaseName);
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
?>