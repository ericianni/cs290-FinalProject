<!DOCTYPE html>
<html>
<head>
	<title>Inventory Home</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="account.js"></script>
	<link rel="stylesheet" type="text/css" href="inventory.css">
</head>
<body>
	<h1>Shop Inventory System</h1>
	<div id="loginCon">
		<h3>Login Below</h3>
		<div id="loginMessage">
			<?php include "login.php"; ?>
		</div>

		<form id="login">
			<input type="text" id="usernameL" placeholder="Username" /><br/>
			<input type="password" id="passwordL" placeholder="Password" /><br />
			<input type="button" id="submitL" value="Login" />
		</form>
		<p>
			<h3>Need an Account?</h3><button id="regButton">Register</button>
		</p>
	</div>
	
</body>
</html>