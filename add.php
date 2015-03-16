<?php 
	include 'config.php';
	if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['username'])) {
		echo 'There was an error, please try again.<br />';
		//echo "<a href=\"index.php\"><button id=\"redirect\">Go To Homepage</button></a>";
		exit;
	}
	if(isset($_POST['checkProduct'])) {
		$product = $_POST['product'];
		$username = $_SESSION['username'];
		$checkProduct = $mysqli->prepare("SELECT * FROM inventory WHERE username = ? AND product = ?");
		$checkProduct->bind_param('ss', $username, $product);
		$checkProduct->execute();
		$checkProduct->store_result();
		if($checkProduct->num_rows == 1) {	//user exists already
			echo 'Product Already Exists';
		} else {
			echo 'Product Not In Database';
		}
		$checkProduct->close();
		exit;
	}

	$product = strtoupper($_POST['product']);
	$cost = $_POST['cost'];
	$quantity = $_POST['quantity'];
	$username = $_SESSION['username'];
	$checkProduct = $mysqli->prepare("SELECT * FROM inventory WHERE username = ? AND product = ?");
	$checkProduct->bind_param('ss', $username, $product);
	$checkProduct->execute();
	$checkProduct->store_result();
	if($checkProduct->num_rows == 1) {
		echo 'Product Already In Inventory';
	} elseif(!is_numeric($cost)) {
		echo 'Cost Must Be A Number';
		} elseif (!is_numeric($quantity)) {
			echo 'Quantity Must Be a Number';
			} else {
				$add = $mysqli->prepare("INSERT INTO inventory (username, product, cost, quantity) VALUES (?,?,?,?)");
				$add->bind_param('ssdi', $username, $product, $cost, $quantity);
				if($add->execute()) {
					echo 'Successfully Added';
				}
				$add->close();
			}

?>