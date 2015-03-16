<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="account.js"></script>
	<link rel="stylesheet" type="text/css" href="inventory.css">
</head>
<body>
<h1>Store Inventory System<button id="redirect">Home</button></h1>
<div id="registerCon">
		<div id="loginMessage">
			<?php include "login.php"; ?>
		</div>
		<h3>To Register, fill out the form below</h3>
		<div id="registerMessage"></div>
		<form id="register">
			<input type="text" id="usernameR" placeholder="Username" /><span id="userStatus"></span><br/>
			<input type="password" id="password1" placeholder="Password" /><br/>
			<input type="password" id="password2" placeholder="Re-enter Password" /><span id="passwordStatus"></span><br/>
			<input type="text" id="emailR" placeholder="Email Address" /><span id="emailStatus"></span><br />
			<input type="button" id="submitR" value="Register" />
		</form>
	</div>
</body>
</html>