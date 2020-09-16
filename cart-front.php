<?php 
session_start();
require_once 'Cart.php';
$Cart = new Cart();
$cart = "";

	if (isset($_POST['submit'])) {
		$id = time();
		$quantity = $_POST['quantity'];
		$item = $_POST['item'];
		$price = $_POST['price'];

		$Cart->add($item, $quantity, $id, $price);
		echo $Cart->quantify()." item(s) in cart<br>";
	} else {
		echo $Cart->quantify()." item(s) in cart";
	}

	if (isset($_GET['decrement'])) {
		$Cart->decrement($_GET['decrement']);
		header('location:index.php');
	}
	if (isset($_GET['increment'])) {
		$Cart->increment($_GET['increment']);
		header('location:index.php');
	}
	if (isset($_GET['remove'])) {
		$Cart->remove($_GET['remove']);
		header('location:index.php');
	}


	if (isset($_POST['empty'])) {
		$Cart->discard();
		header('location:index.php');
	}

	$cart = json_decode($Cart->load());

?>
<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
</head>
<body>
	<form method="POST">
		<input type="submit" name="empty" value="Empty Cart">
	</form>

	<h1>insert</h1>
	<form method="POST" action="">
		<input type="num" name="quantity" placeholder="Quantity" required>
		<br>
		<input type="text" name="item" placeholder="Item" required>
		<br>
		<input type="num" name="price" placeholder="Price" required>
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<?php if ($cart) { ?>
	<h1>Cart</h1>
	<table>
		<tr>
			<th>Qty</th>
			<th>Item</th>
			<th>Rate</th>
			<th>Total</th>
		</tr>
	<?php 
	
	
	foreach ($cart as $item) { ?>
		<tr>
			<td>
				<a href="index.php?decrement=<?php echo $item->name; ?>"><input type="button" value="-"></a>
				<?php echo $item->quantity; ?>
				<a href="index.php?increment=<?php echo $item->name; ?>"><input type="button" value="+"></a>
			</td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->price ?></td>
			<td><?php echo $Cart->subtotal($item->name); ?></td>
			<td> <a title="Remove" href="index.php?remove=<?php echo $item->name; ?>" style="text-decoration: none; color: red; font-weight: bold;">&times;</a></td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="3">Charges</td>
			<td><?php echo $Cart->total()['charges']; ?></td>
		</tr>
		<tr>
			<td colspan="3">Total</td>
			<td><?php echo $Cart->total()['total']; ?></td>
		</tr>
	<?php } ?>
	</table>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>