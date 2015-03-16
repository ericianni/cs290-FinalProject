<?php 
	/**
	 * This file contains all the code to implement both logging in
	 * and registering with the site. 
	 */
	include "config.php";

	/**
	 * Checks to see if the user is logged in. The additional checks
	 * on the $_POST object are to allow use of this same code for 
	 * checking input validity before submitting.
	 */
	if(isset($_SESSION['loggedIn']) && isset($_SESSION['username']) && 
		!(isset($_POST['checkUser']) || isset($_POST['checkEmail']) || isset($_POST['register']))) {
		//user already logged in
		echo "<div>";
		echo $_SESSION['username'].' is currently logged in</div>';
		echo "<button id=\"redirect2\">Shop Inventory</button>";
		echo "<button id=\"logout\">Logout</button>";
	} else {
		if(isset($_POST['usr']) && isset($_POST['pw'])) {
			//user submitted a login request
			$username = $_POST['usr'];
			$password = $_POST['pw']; 

			$checkReg = $mysqli->prepare("SELECT Email FROM users WHERE Username = ? AND Password = ?");
			$checkReg->bind_param('ss', $username, $password);
			$checkReg->execute();
			$checkReg->store_result();
			$checkReg->bind_result($email);
			$checkReg->fetch();

			if($checkReg->num_rows == 1) {	//user exists with that password
							
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['loggedIn'] = 1;
				echo 'Successfully logged in';
				
			} else {
				echo 'No account with that information';
			}
			$checkReg->close();
		}
	}

	/**
	 * Checks to see if the username is already taken
	 */
	if(isset($_POST['checkUser'])) {
		$username = $_POST['checkUser'];
		$checkUser = $mysqli->prepare("SELECT * FROM users WHERE Username = ?");
		$checkUser->bind_param('s', $username);
		$checkUser->execute();
		$checkUser->store_result();
		if($checkUser->num_rows == 1) {	//user exists already
			echo 'Username Taken';
		} else {
			echo 'Username Available';
		}
		$checkUser->close();
	}

	/**
	 * Checks to see if the email is in a valid format
	 */
	if(isset($_POST['checkEmail'])) {
		$email = $_POST['checkEmail'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo 'Please Enter A Valid Email';
		} else {
			$checkEmail = $mysqli->prepare("SELECT * FROM users WHERE Email = ?");
			$checkEmail->bind_param('s', $email);
			$checkEmail->execute();
			$checkEmail->store_result();
			if($checkEmail->num_rows == 1) {	//user exists already
				echo 'Email Already Used';
			} else {
				echo 'Email Not Used';
			}
			$checkEmail->close();
		}
	}

	/**
	 * Attempts to register user with inputted information.
	 * Returns a string of success or an error.
	 */
	if(isset($_POST['register'])) {
	    $username = $_POST['usr'];
	    $password1 = $_POST['pw1'];
	    $password2 = $_POST['pw2'];
	    $email = $_POST['emai'];

	    $checkUser = $mysqli->prepare("SELECT * FROM users WHERE Username = ?");
		$checkUser->bind_param('s', $username);
		$checkUser->execute();
		$checkUser->store_result();

		$checkEmail = $mysqli->prepare("SELECT * FROM users WHERE Email = ?");
		$checkEmail->bind_param('s', $email);
		$checkEmail->execute();
		$checkEmail->store_result();

		if($username == '') {	//user didn't enter a username
	    	echo '<div>Please enter a user name</div>';
	   		} elseif ($password1 == '' || $password2 == '') {	//user didn't enter one/both passwords
	    		echo '<div>Please ensure you entered password twice</div>';
	    		} elseif($checkUser->num_rows == 1) {	//user exists already
					echo '<div>Username taken</div>'; //returns 'used' to indicate username is taken
					} elseif($password1 != $password2) {
						echo '<div>Passwords do not match</div>';
						} elseif($checkEmail->num_rows == 1) {	//user picked an email already used
							echo '<div>Email already used</div>';
							} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
								echo '<div>Please enter a valid email</div>';
								} else {
									$register = $mysqli->prepare("INSERT INTO users (Username, Password, Email) VALUES (?,?,?)");
									$register->bind_param('sss', $username, $password1, $email);
									if($register->execute()) {
										echo '<div>Registration Successful!</div><button id="goToLogin" onclick="goToLogin()">';
										echo 'Go To Login</button>';
									}
									$register->close();
								}
		$checkEmail->close();
		$checkUser->close();
	}
?>