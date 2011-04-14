<?php

class artifact {

	function generate($items){
		
		foreach ($items as $item) {
			
			$pickupKey = str::gen(15);
			
			$_SESSION['artifacts'][$pickupKey] = $item;
			
			$artifacts[$pickupKey] = array(
				'item_id'=>$item['item_id'],
				'artifact'=>'item',
				'key'=>$pickupKey
				);		
					
			if (substr($item['item_id'],0,1) == '#'){
			
				$artifacts[$pickupKey]['size'] = money::get_bill_size(substr($item_id,1));
				$artifacts[$pickupKey]['artifact'] = 'money';
				
			}

		}
		
		return $artifacts;
		
	}
	
	function destroy(){
	
	}

}

?>