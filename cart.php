<?php 
class Cart 
{
	public function add($item, $quantity, $id, $price)
	{
		if (array_key_exists($item, $_SESSION)) {
			$_SESSION[$item]['quantity'] = $_SESSION[$item]['quantity'] + $quantity;
		} else {
			$_SESSION[$item] = 
			[
				'id'	   => $id,
				'name'	   => $item,
				'quantity' => $quantity, 
				'price'    => $price
			];
		}
	} 

	public function increment($item) //increment the quantitiy of the item once
	{
		$_SESSION[$item]['quantity'] ++;
	}

	public function decrement($item) //decrement the quantitiy of the item once
	{	
		($_SESSION[$item]['quantity'] == 1) ?  $_SESSION[$item]['quantity'] == 1 : $_SESSION[$item]['quantity'] --;
	}

	public function remove($item) //remove the item from cart
	{
		unset($_SESSION[$item]);
	}

	public function discard() //empty cart
	{
		session_unset();
	}

	public function load() //load cart in json encoded format
	{
		return ($_SESSION == NULL) ? 'Cart is Empty' : json_encode($_SESSION);
	}

	function quantify() //return subtotal for a given item
	{
		return count($_SESSION);
	}

	function subtotal($item) //return subtotal for a given item
	{
		$subtotal = $_SESSION[$item]['quantity'] * $_SESSION[$item]['price'];
		return $subtotal;
	}

	function total() //return total amount for all the items in cart
	{
		$total['total'] = 0;
		$total['charges'] = 0;


		foreach ($_SESSION as $item) {
			$total['total'] += $item['quantity'] * $item['price'];
		}

		if ($total['total'] <= 200) {
			$total['charges'] = 20;
			$total['total'] = $total['total'] + $total['charges'];
		}
		return $total;
	}

}



?>
