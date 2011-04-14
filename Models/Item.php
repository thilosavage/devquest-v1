<?php 
class Item extends Model {

	protected $table = 'item';
	protected $id_field = 'item_id';
	protected $name_field = 'name';
	protected $order_by = 'value DESC';
	
	function get_random($level){
		$this->clear();
		$this->custom('SELECT * FROM item t JOIN 
		(SELECT(FLOOR(max(item_id) * rand())) as maxid FROM item) 
		as tt on t.item_id >= tt.maxid WHERE level=%s LIMIT 1',$level);
	
	}
	
	function unequip_type($type) {
		$this->custom(
			"UPDATE item_user, item SET equipped='0' 
			WHERE item_user.item_id = item.item_id 
			AND item.type = '%s' AND item_user.user_id = '%s'",
			$type,$_SESSION['user']['user_id']);
	}
	
	
	function generate_artifacts($level,$custom_artifacts) {
		
		$arts = mt_rand(1,100);
	
		if ($arts == 1) {
			$quantity = 1;
			$quality = 12;
		}
		else if ($arts > 90) {
			$quantity = 2;
			$quality = 6;
		}
		else if ($arts > 50) {
			$quantity = 2;
			$quality = 3;
		}
		else {
			$quantity = 3;
			$quality = 2;
		}
		
		$a = 0;
		
		
		
		if ($custom_artifacts) {
			foreach ($custom_artifacts as $artifact) {
			
				$pickupKey = str::gen(15);
			
				$_SESSION['artifacts'][$pickupKey][$a] = $artifact;
				
			}
		}
		
		else {
			while ($a < $quantity) {
			
				$pickupKey = str::gen(15);
				$this->get_random($level);
				
				$artifacts[] = array(
					'item_id'=>$this->row['item_id'],
					'key'=>$pickupKey
					);

				$_SESSION['artifacts'][$pickupKey] = $this->row;
				
				foreach (settings::$attribs as $attrib) {
					$_SESSION['artifacts'][$pickupKey][$attrib] = $this->row[$attrib];
				}
				$a++;
				
			}	
		}
		
		return $artifacts;
	
	}
	function generate_cash($level) {
		
		$arts = mt_rand(1,100);
	
		if ($arts == 1) {
			$quantity = 1;
			$quality = 12;
		}
		else if ($arts > 90) {
			$quantity = 2;
			$quality = 6;
		}
		else if ($arts > 50) {
			$quantity = 2;
			$quality = 3;
		}
		else {
			$quantity = 3;
			$quality = 2;
		}

		$amount = rand(20,40);
		
		$pickupKey = str::gen(15);
		
		$cash = array(
			'amount'=>$amount,
			'size'=>money::get_bill_size(substr($amount,1)),
			'key'=>$pickupKey
			);

		$_SESSION['cash'][$pickupKey] = $amount;

		
		return $cash;	
	
	}	
	
	
	function calculate_value($value,$quality) {
		return ceil($value + $quality);
	}
}
?>