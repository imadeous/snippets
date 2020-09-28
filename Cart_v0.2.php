<?php 
error_reporting(0);
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
					'subtotal' => ($_SESSION['cart'][$id]['quantity'] + $quantity) * $price,
					'tax'	   => $tax
				];
		} else {
			$_SESSION['cart'][$id] = 
			[
				'id'	   => $id,
				'name'	   => $name,
				'quantity' => $quantity, 
				'price'    => $price,
				'subtotal' => $quantity * $price,
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
		foreach ($_SESSION['cart'] as $item) {
			$subtotal += round($item['subtotal'], 2);
		}
		return $subtotal;
	}

	//retrun the sum of all item taxes
	public function tax_total()
	{
		$tax_total = 0;
		foreach ($_SESSION['cart'] as $item) {
			$tax_total += round($item['subtotal'] * $item['tax'], 2);
		}
		return $tax_total;
	}

	//retrun the grand total
	public function grand_total()
	{
		$grand_total = round($this->subtotal() + $this->tax_total(), 2);
		return $grand_total;
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
		return json_encode(array_reverse($_SESSION['cart']));
	}

}


// instentiation
$Cart = new Cart();

//add function call(taxed)
$Cart->add("LOREM", "Tuna", 1, 100, 0.06);

//add function call(non-taxed)
$Cart->add("IPSUM", "Skipjack", 1, 100);

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
