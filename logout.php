<?php 
	/**
	 * Logs the current user out by destroying the session
	 */
	include 'config.php';
	$_SESSION = array();
	session_destroy();
	echo '<div>Successfully Logged Out</div>';
?>