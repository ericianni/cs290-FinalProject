<?php 
	/**
	 * Handles the requests from the user to the database.
	 */

	include 'config.php';

	/**
	 * Checks to see if the user isn't logged in.
	 */
	if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['username'])) {
		echo 'There was an error, please try again.<br />';
		echo "<a href=\"index.php\"><button id=\"redirect\">Go To Homepage</button></a>";
		exit;
	}

	/**
	 * Gets the user's items from the table
	 */
	if(isset($_POST['load'])) {
		$username = $_SESSION['username'];
		$items = $mysqli->prepare("SELECT * FROM inventory WHERE username = ?");
		$items->bind_param('s', $username);
		$items->execute();
		$res = $items->get_result();

		while($row = $res->fetch_assoc()) {
			echo "<div class=\"item\" id=\"".$row['id']."\"><span class=\"product\">Product: ".$row['product']."</span>";
			echo "Cost:<span class=\"cost\">$".number_format($row['cost'], 2)."</span>";
			echo "<span>Quantity: </span>";
			echo "<input class=\"quantity\" type=\"text\" value=\"".$row['quantity']."\" />";
			$update = "<button class=\"updateButton\"onclick=\"update(this.parentNode)\">Update</button>";
			echo $update;
			$statement = 'removeItem(this.parentNode)';
			echo "<button class=\"removeButton\" onclick=\"".$statement."\">Remove</button></div>";
		}
		exit;
	}

	/**
	 * Checks to see if the user inputted product name
	 * already exists in the table.
	 */
	if(isset($_POST['checkProduct'])) {
		$product = $_POST['checkProduct'];
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

	/**
	 * checks to see if user inputted a number for cost.
	 */
	if(isset($_POST['checkCost'])) {
		if(!is_numeric($_POST['checkCost'])) {
			echo 'Cost needs to be a number';
			exit;
		}
	}

	/**
	 * Checks to see if user inputted quantity is an integer
	 */
	if(isset($_POST['checkQuantity'])) {
		if(!ctype_digit($_POST['checkQuantity'])) {
				echo 'Quantity needs to be an integer';
				exit;
		}
	}

	/**
	 * Attempts to add an item to the table. If anything is wrong
	 * with the user input an error is returned.
	 */
	if(isset($_POST['add'])) {
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
			} elseif (!ctype_digit($quantity)) {
				echo 'Quantity Must Be an Integer';
				} else {
					$add = $mysqli->prepare("INSERT INTO inventory (username, product, cost, quantity) VALUES (?,?,?,?)");
					$add->bind_param('ssdi', $username, $product, $cost, $quantity);
					if($add->execute()) {
						echo 'Successfully Added';
					} else {
						echo 'There Was A Problem Adding Item';
					}
					$add->close();
				}
	exit;
	}
	/**
	 * Attempts to remove an item from the database. 
	 */
	if(isset($_POST['removeId'])) {
		$remove = $mysqli->prepare('DELETE FROM inventory WHERE id = ? AND username = ?');
		$remove->bind_param('is', $_POST['removeId'], $_SESSION['username']);
		if($remove->execute()) {
			echo 'Successfully Removed';
		}
		$remove->close();
		exit;
	}

	/**
	 * This code is no longer used
	 */
	if(isset($_POST['incId'])) {
		$newVal = $_POST['quantity'] + 1;
		$inc = $mysqli->prepare("UPDATE inventory SET quantity = ? WHERE id = ? AND username = ?");
		$inc->bind_param('iis', $newVal, $_POST['incId'], $_SESSION['username']);
		if($inc->execute()) {
			echo $newVal;
		}
		exit;
	}

	/**
	 * This code is no longer used
	 */
	if(isset($_POST['decId'])) {
		$newVal = $_POST['quantity'] - 1;
		$inc = $mysqli->prepare("UPDATE inventory SET quantity = ? WHERE id = ? AND username = ?");
		$inc->bind_param('iis', $newVal, $_POST['incId'], $_SESSION['username']);
		if($inc->execute()) {
			echo $newVal;
		}
		exit;
	}

	/**
	 * Attempts to update the quantity of an item
	 */
	if(isset($_POST['updateId'])) {
		$newVal = $_POST['quantity'];
		if(!is_numeric($newVal)) {
			echo 'Please only enter an integer';
			exit;
		}
		if(!ctype_digit($newVal)) {
			echo 'Please only enter an integer';
			exit;
		}
		$inc = $mysqli->prepare("UPDATE inventory SET quantity = ? WHERE id = ? AND username = ?");
		$inc->bind_param('iis', $newVal, $_POST['updateId'], $_SESSION['username']);
		if($inc->execute()) {
			echo 'Updated Successfully';
		} else {
			echo 'There Was A Problem';
		}
		exit;
	}
?>