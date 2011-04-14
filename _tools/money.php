<?php
class money {

	public static function get_bill_size($amount) {
	
		if ($amount > 1000000) {
			$bill = '10';
		}
		else if ($amount > 100000) {
			$bill = '9';
		}
		else if ($amount > 50000) {
			$bill = '8';
		}
		else if ($amount > 20000) {
			$bill = '7';
		}
		else if ($amount > 8000) {
			$bill = '6';
		}				
		else if ($amount > 1500) {
			$bill = '5';
		}						
		else if ($amount > 500) {
			$bill = '4';
		}						
		else if ($amount > 100) {
			$bill = '3';
		}					
		else if ($amount > 20) {
			$bill = '2';
		}		
		else {
			$bill = '1';
		}
		
		return $bill;
	}
}
?>