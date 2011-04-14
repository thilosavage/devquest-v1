<?php

class bagController extends Controller {

	function ajax_bagItemsLoad(){
		
		
		$items = array();
		$uitems = array();
		
		$userObj = new User($_SESSION['user']['user_id']);
		
		$item_userObj = new Item_user(array(
			'user_id'=>$_SESSION['user']['user_id']
			));


		$attribs = settings::$attribs;
		
		$itemIds = array();
		$user_items = $item_userObj->data;
		
		foreach ($user_items as $user_item){
			
			if (!in_array($user_item['item_id'],$itemIds)){
				$itemIds[] = $user_item['item_id'];
			}
		
		
		}
		
		$itemObj = new Item($itemIds);
		$f = 0;
		foreach ($user_items as $item){
			
			
			//$cumulative = $itemObj->data[$item['item_id']]['cumulative'];

			
			if (!$itemObj->data[$item['item_id']]['type']) {
				if ($items[$item['item_id']]) {
					$items[$item['item_id']]['quantity']++;
				}
				else {
					$items[$item['item_id']] = $itemObj->data[$item['item_id']];
					$items[$item['item_id']]['item_user_id'] = $item['item_user_id'];
					$items[$item['item_id']]['quantity'] = 1;
					$items[$item['item_id']]['value'] = ceil($item['value'] * settings::store_resell_percentage);
					
					foreach ($attribs as $attrib){
						$value = $itemObj->data[$item['item_id']][$attrib];
						if ($value > 0) {
						
							$items[$item['item_id']]['attribs'][$attrib] = $value;

						}
					}
				}
			}
			
			else {
				
				$uitems[$f] = $itemObj->data[$item['item_id']];
				$uitems[$f]['item_user_id'] = $item['item_user_id'];
				$uitems[$f]['equipped'] = $item['equipped'];
				$uitems[$f]['value'] = ceil($item['value'] * settings::store_resell_percentage);
				
				foreach ($attribs as $attrib){
					$value = $item[$attrib];
					$attribArray = array();
					
					if ($value > 0) {
					
						$uitems[$f]['attribs'][$attrib] = $value;

					}
				}
				$f++;
			}
		}
		
		$items = array_merge($items,$uitems);

		
		$this->vars('items',$items);

	
	
	}
}
?>