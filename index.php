<?php

class Basket {
	
	
	public $productsInCart = [];
	
	protected $products = [
		'R01' => 32.95,
		'G01' => 24.95,
		'B01' => 7.95,
	];
	
	protected $shippingOffers = [
		'90' => 0,
		'50' => 2.95,
		'0' => 4.95,
	];
	
	public function add($productCode) 
	{
		if(array_key_exists($productCode, $this->products)) {
			
			if(!isset($this->productsInCart[$productCode])) {
				$this->productsInCart[$productCode] = 0;
			}
			$this->productsInCart[$productCode] += 1;
		}
	}
	
	public function applyPromo1($productCode, $qty)
	{
		if($productCode == 'R01') { // modify the qty only if R01
			if($qty % 2 == 0 && $qty > 1) {
				$qty = $qty * 0.75;
			} else {
				
				$val_products_temp = ($qty - 1) * 0.75;
				$qty = $val_products_temp + 1;
			}
		}
		
		return $qty;
	}
	
	public function total()
	{
		$total = 0;
		foreach ($this->productsInCart as $productCode => $qty) {
			$qty = $this->applyPromo1($productCode, $qty);
			$total += $this->products[$productCode] * $qty;
			
		}
		
		$shipping = 0;
		foreach ($this->shippingOffers as $key_shipping => $val_shipping) {
			
			if ($total >= $key_shipping) {
				$shipping = $val_shipping;
				break;
			}
		}
		
		return floor( ( $total + $shipping ) * 100 ) / 100;
	}
}