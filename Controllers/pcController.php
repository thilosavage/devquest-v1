<?php

class pcController extends Controller {

	function ajax_pcUtilityOpen() {
		
		$item_userObj = new Item_user(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'equipped'=>'1'
			));
			

		foreach ($item_userObj->data as $item_user) {
			$item_userIds[] = $item_user['item_id'];
		}

		$itemObj = new Item;
		$itemObj->custom_id = 'type';
		$itemObj->load($item_userIds);
		
		$this->vars('parts',$itemObj->data);
		
		$this->vars('score',$score);
	
	}


}
?>