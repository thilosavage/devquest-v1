<?php
class itemController extends Controller {
	
	
	function ajax_itemBuyProcess($sitem_id){
	
		$error = 0;
		
		$item = $_GET['s']?$_SESSION['store']['items'][$sitem_id]:$_SESSION['sells']['item'];
		
		
		if (!$_SESSION['store']['items'][$sitem_id]['cumulative']) {
			$_SESSION['store']['items'][$sitem_id];
		}
		
		
		
		//$itemObj = new Item($item_id);
		$userObj = new User($_SESSION['user']['user_id']);

		if ($item['value'] > $userObj->row['money']) {
			$error = 1;
		}
		
		if (!$sitem_id || !$item) {
			$error = 4;
		}

		if (!$error){
	
			//$item_userObj = new Item_user(array(
			//	'item_id'=>$item['item_id'],
			//	'user_id'=>$_SESSION['user']['user_id']
			//	));	
			
			$item_userObj = new Item_user;	
			$itemObj = new Item;	
		
			$attribs = settings::$attribs;
			
			foreach ($attribs as $attrib) {
				$item_userObj->set[$attrib] = $item[$attrib];
			}
			
			
			$item_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$item_userObj->set['item_id'] = $item['item_id'];
			$item_userObj->set['value'] = $item['value'];
			
			$item_userObj->save();
			
			$newMoney = $userObj->row['money'] - $item['value'];
			
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['money'] = $newMoney;
			$userObj->save();
			
			$_SESSION['user']['money']  = $newMoney;
			
			$this->vars('cost',$itemObj->row['value']);
			$this->vars('money',$userObj->set['money']);
			
		}

		$this->vars('error',$error);
		$this->vars('cumulative',$item['cumulative']);
		
	}
	
	function ajax_itemUseProcess($item_id){
	
		$itemObj = new Item($item_id);
		$userObj = new User;
		
		$item_userObj = new Item_user(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'item_id'=>$item_id
			));
		
		if ($item_userObj->data){
		
		
			if ($itemObj->row['ram']){
			
				$newRam = $_SESSION['user']['ram'] + $itemObj->row['ram'];
				
				if ($newRam > $_SESSION['user']['max_ram']) {
					$newRam = $_SESSION['user']['max_ram'];
				}

				$_SESSION['user']['ram'] = $newRam;
				$updates['ram'] = $newRam;
				
				$userObj->set['user_id'] = $_SESSION['user']['user_id'];
				$userObj->set['ram'] = $newRam;
				$userObj->save();
				
				$item_userObj->delete($item_userObj->row['item_user_id']);
				
				$type = 'ram';
				
			}
			if ($itemObj->row['hp']){
			
				$newHP = $_SESSION['user']['hp'] + $itemObj->row['hp'];
				
				if ($newHP> $_SESSION['user']['max_hp']) {
					$newHP = $_SESSION['user']['max_hp'];
				}

				$_SESSION['user']['hp'] = $newHP;
				$updates['hp'] = $newHP;
				
				$userObj->set['user_id'] = $_SESSION['user']['user_id'];
				$userObj->set['hp'] = $newRam;
				$userObj->save();
				
				$item_userObj->delete($item_userObj->row['item_user_id']);
				
				$type = 'hp';
				
			}			
			
			
		}
		else {
			echo "You don't have this item....";
		}
		
		$this->vars('type',$type);
		$this->vars('updates',$updates);
		$this->vars('cumulative',$itemObj->row['cumulative']);
		
	}
	
	function ajax_itemSellProcess($item_user_id){

		
		$userObj = new User;
		
		$item_userObj = new Item_user($item_user_id);
		$itemObj = new Item($item_userObj->row['item_id']);
		
		if ($item_userObj->row['user_id'] !== $_SESSION['user']['user_id']) {
			$error = 7;
		}

		
		if (!$error){

			//$itemObj = new Item($item_userObj->row['item_id']);
			
			$value = ceil($item_userObj->row['value'] * settings::store_resell_percentage);
			
			$newMoney = $_SESSION['user']['money'] + $value;
			
			$_SESSION['user']['money'] = $newMoney;

			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['money'] = $newMoney;
			$userObj->save();
			
			$item_userObj->delete($item_userObj->row['item_user_id']);

		}
		
	
		$this->vars('error',$error);
		$this->vars('value',$value);
		$this->vars('money',$newMoney);
		$this->vars('cumulative',$itemObj->row['cumulative']);
	
	}
	
	function ajax_itemEquipProcess($item_user_id){
		
		$item_userObj = new Item_user(array(
			'item_user_id'=>$item_user_id,
			'user_id'=>$_SESSION['user']['user_id']
			));
		
		if ($item_userObj->row) {
			
			$itemObj = new Item($item_userObj->row['item_id']);
			
			$item = $itemObj->row;
			
			$itemObj->unequip_type($itemObj->row['type']);
			
			$item_userObj->set['item_user_id'] = $item_user_id;
			$item_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$item_userObj->set['equipped'] = 1;
			$item_userObj->save();
			
			$message = 'message';

			if ($item['max_hp']) {
				$_SESSION['user']['max_hp'] = $_SESSION['user']['max_hp'] + $item_userObj->row['max_hp'];
			}
			if ($item['max_ram']) {
				$_SESSION['user']['max_ram'] = $_SESSION['user']['max_ram'] + $item_userObj->row['max_ram'];
			}
			
			$item_userObj->clear();
			

		}
		else {
			$error = 'OH NO';
		}

		$this->vars('max_ram',$_SESSION['user']['max_ram']);
		$this->vars('max_hp',$_SESSION['user']['max_hp']);
		$this->vars('error',$error);
		$this->vars('message',$message);
	
	}
	
	function ajax_itemUnequipProcess($item_user_id){

		$item_userObj = new Item_user(array(
			'item_user_id'=>$item_user_id,
			'user_id'=>$_SESSION['user']['user_id']
			));
		
		if ($item_userObj->row) {
			
			//$itemObj = new Item($item_userObj->row['item_id']);
			
			$item_userObj->set['item_user_id'] = $item_user_id;
			$item_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$item_userObj->set['equipped'] = 0;
			$item_userObj->save();
			
			$message = 'message';
			
			$userObj = new User;
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			if ($item_userObj->row['max_hp']) {
				$_SESSION['user']['max_hp'] = $_SESSION['user']['max_hp'] - $item_userObj->row['max_hp'];
				
				if ($_SESSION['user']['max_hp'] < $_SESSION['user']['hp']) {		
					$_SESSION['user']['hp'] = $_SESSION['user']['max_hp'];
				}
				$userObj->set['hp'] = $_SESSION['user']['hp'];
				$userSave = true;

			}
			if ($item_userObj->row['max_ram']) {
				$_SESSION['user']['max_ram'] = $_SESSION['user']['max_ram'] - $item_userObj->row['max_ram'];
				
				if ($_SESSION['user']['max_ram'] < $_SESSION['user']['ram']) {
					$_SESSION['user']['ram'] = $_SESSION['user']['max_ram'];
				}
				$userObj->set['ram'] = $_SESSION['user']['ram'];
				$userSave = true;
			}
		}
		else {
			$error = 'OH NO';
		}
		
		if ($userSave) {
			$userObj->save();
		}
		
		
		$this->vars('hp',$_SESSION['user']['hp']);
		$this->vars('ram',$_SESSION['user']['ram']);		
		$this->vars('max_hp',$_SESSION['user']['max_hp']);
		$this->vars('max_ram',$_SESSION['user']['max_ram']);
		
		$this->vars('error',$error);
		$this->vars('message',$message);	
	
	}
	
	
	function ajax_itemDestroyProcess($item_user_id) {
	
		$item_userObj = new Item_user;
		$item_userObj->delete($item_user_id);
		
		$this->vars('success',true);
	}
	
}
?>