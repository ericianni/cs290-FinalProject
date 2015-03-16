<?php 
	include "config.php";

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

	if(isset($_POST['register'])) {
	    $username = $_POST['usr'];
	    $password1 = $_POST['pw1'];
	    $password2 = $_POST['pw2'];
	    $email = $_POST['emai'];
	    //echo $username.$password.$email;
	    $checkUser = $mysqli->prepare("SELECT * FROM users WHERE Username = ?");
		$checkUser->bind_param('s', $username);
		$checkUser->execute();
		$checkUser->store_result();

		$checkEmail = $mysqli->prepare("SELECT * FROM users WHERE Email = ?");
		$checkEmail->bind_param('s', $email);
		$checkEmail->execute();
		$checkEmail->store_result();
		if($checkUser->num_rows == 1) {	//user exists already
			echo 'Username Taken'; //returns 'used' to indicate username is taken
		} else {
			if($password1 != $password2) {
				echo 'Passwords Do Not Match';
			} else {
				if($checkEmail->num_rows == 1) {
					echo 'Email Already Used';
				} else {
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo 'Please Enter A Valid Email';
					} else {
						//username isn't used already
						$register = $mysqli->prepare("INSERT INTO users (Username, Password, Email) VALUES (?,?,?)");
						$register->bind_param('sss', $username, $password1, $email);
						if($register->execute()) {
							echo 'Registration Successful!<br />Please Log In Above'; //returns 'success' to show registration worked
						}
						$register->close();
						}
					}
				}
		}
		$checkEmail->close();
		$checkUser->close();
	}
	$mysqli->close();
 ?>