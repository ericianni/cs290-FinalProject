
<!DOCTYPE html>
<html>
<head>
	<title>Shop Inventory</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="inventory.js"></script>
	<link rel="stylesheet" type="text/css" href="inventory.css">
</head>
<body>
<?php include 'config.php'; 
	if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['username'])) {
		echo '<h1>You need to log in to view this page.';
		echo "<button id=\"redirect\">Go To Login</button></h1>";
		exit;
	} else {
	echo "<h1>Welcome ".$_SESSION['username'];
	echo '<button id="redirect">Home</button>';
	echo '<button id="logout">Log Out</button></h1>';
	}
?>

<div id="pageStatus"></div>
<form id="addForm">
	<input id="product" type="text" placeholder="Product Name"/><span id="productStatus"></span><br />
	<input id="cost" type="text" placeholder="Cost"/><span id="costStatus"></span><br />
	<input id="quantity" type="text" placeholder="Quantity"/><span id="quantityStatus"></span><br />
	<input type="button" id="submitAdd" value="Add Product"><span id="addedStatus"></span>
</form>

<div id="shopInventory">
	
</div>
</body>
</html>