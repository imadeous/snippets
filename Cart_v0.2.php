<?php 
session_start();
class Cart 
{
	public function __construct(){
		$this->totals();
	}

	//add item with $id, $name, $quantity, $price ad $tax (percentage in decimal eg: 0.06 for 6%)
	public function add($id, $name, $quantity, $price, $tax = 0)
	{
		if(array_key_exists($id, $_SESSION['cart'])){
			$_SESSION['cart'][$id] = 
				[
					'id'	   => $id,
					'name'	   => $name,
					'quantity' => $_SESSION['cart'][$id]['quantity'] + $quantity,
					'price'    => $price,
					'subtotal' => round(($_SESSION['cart'][$id]['quantity'] + $quantity) * $price, 2),
					'tax'	   => $tax
				];
		} else {
			$_SESSION['cart'][$id] = 
			[
				'id'	   => $id,
				'name'	   => $name,
				'quantity' => $quantity, 
				'price'    => $price,
				'subtotal' => round($quantity * $price, 2),
				'tax'	   => $tax
			];
		}
		$this->totals();
	}

	//remove item witd id = $id
	public function remove($id)
	{
		unset($_SESSION['cart'][$id]);
		$this->totals();
	}

	//empty cart
	public function discard()
	{
		unset($_SESSION['cart']);
	}
	
	//increment the quantity of the item once
	public function increment($id)
	{
		$_SESSION['cart'][$id]['quantity'] ++;
		$_SESSION['cart'][$id]['subtotal'] = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
		$this->totals();
	}

	//increment the quantity of the item once
	public function decrement($id) 
	{
		($_SESSION['cart'][$id]['quantity'] <= 1) ?  $_SESSION['cart'][$id]['quantity'] == 1 : $_SESSION['cart'][$id]['quantity'] --;
		$_SESSION['cart'][$id]['subtotal'] = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
		$this->totals();
	}

	//retrun the sum of all item totals
	public function subtotal()
	{
		$subtotal = 0;
		if(isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $item => $value) {
				if(array_key_exists($item, $_SESSION['cart']) && $item != 'grand_total' && $item != 'tax_total'&& $item != 'subtotal') {
					$subtotal += $_SESSION['cart'][$item]['subtotal'];
				}
			}
			return round($subtotal, 2);
		}
	}

	//retrun the sum of all item taxes
	public function tax_total()
	{
		$tax_total = 0;
		if(isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $item => $value) {
				if(array_key_exists($item, $_SESSION['cart']) && $item != 'grand_total' && $item != 'tax_total'&& $item != 'subtotal') {
					$tax_total += $_SESSION['cart'][$item]['subtotal'] * $_SESSION['cart'][$item]['tax'];
				}
			}
			return round($tax_total, 2);
		}
	}

	//retrun the grand total
	public function grand_total()
	{
		$grand_total = $this->subtotal() + $this->tax_total();
		return round($grand_total, 2);
	}



	//do all the totals at once and set them in sessio cart instance
	public function totals()
	{
		$_SESSION['cart']['grand_total'] = $this->grand_total();
		$_SESSION['cart']['tax_total'] = $this->tax_total();
		$_SESSION['cart']['subtotal'] = $this->subtotal();
	}

	public function load()
	{
		if(isset($_SESSION['cart'])) {
			return json_encode(array_reverse($_SESSION['cart']));
		} else {
			return null;
		}
		
	}

}


// instentiation
$Cart = new Cart();

//add function call(taxed)
$Cart->add("LOREM", "Tuna", 2, 100, 0.06);

//add function call(non-taxed)
$Cart->add("IPSUM", "Skipjack", 1, 100.54);
$Cart->add("Dolor", "Mahi Mahi", 2, 28.39, 0.06);

//remove item function call
// $Cart->remove("LOREM");

//increment item by one function call
// $Cart->increment("LOREM");

// decrement item by one function call
// $Cart->decrement("LOREM");

//empty cart
// $Cart->discard();

// session_destroy();
?>

<pre>
<?php echo $Cart->load() ?>
</pre>
