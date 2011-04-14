<?php

class storeController extends Controller {

	function ajax_storeDataLoad(){
		
		$attribs = settings::$attribs;
		
		$storeObj = new Store(array('loc_id'=>$_SESSION['user']['loc_id']));
		
		// use a session to store temporary store items
		// because i'll never want to save an archive
		// of users store items... i dont think
		$_SESSION['store']['store_id'] = $storeObj->row['store_id'];
		
		if (!$_SESSION['store']['items']) {

			$store = $storeObj->row;
			$store['is_store'] = true;
			
			$itemObj = new Item;
			$itemObj->sort_order = 'value ASC';
			$itemObj->load(array(
				'level'=>$storeObj->row['level'], 
				'in_store'=>'1'
				));

			
			$i = 1;
			foreach ($itemObj->data as $item){
				
				$showItem = rand(1,settings::store_item_probability);
				
				if ($showItem == 1) {
				
					$_SESSION['store']['items'][$i] = $item;
				
					foreach ($attribs as $attrib){
						$attribVal = $itemObj->data[$item['item_id']][$attrib];
						
						$r = mt_rand(1,100);
						
						if ($attribVal > 0) {

							$_SESSION['store']['items'][$i][$attrib] = $attribVal;

						}
					}
					
					if ($item['cumulative']) {
						$dupeItem = 0;
					}
					else {
						$dupeItem = rand(0,settings::store_item_dupes);
					}

					$d = 0;
					while ($d < $dupeItem) {
						$duped = $_SESSION['store']['items'][$i];
						$i++;
						$_SESSION['store']['items'][$i] = $duped;
						
						$quality = 1;
						
						foreach ($attribs as $attrib){
							$attribVal = $itemObj->data[$item['item_id']][$attrib];
							
							$r = mt_rand(1,100);
							
							$topMargin = $item['level'];
							$bottomMargin = $item['level'] - $item['level'] - $item['level'];
							
							if ($attribVal > 0) {
							
								$valueModifier = mt_rand($attribVal+$bottomMargin, $attribVal+$topMargin);
							
								if ($r > 95) {
									$attribVal = $attribVal * 5;
									$quality = $quality + 5;
									$_SESSION['store']['items'][$i]['value'] = $item['value'] + $attribVal * 5;
								}
								else if ($r > 80) {
									$attribVal = $attribVal * 3;
									$quality = $quality + 3;
									$_SESSION['store']['items'][$i]['value'] = $item['value'] + $attribVal * 2;
								}
								else if ($r > 1) {
									$attribVal = $attribVal * 2;
									$quality = $quality + 1;
									
								}
								
								
								$_SESSION['store']['items'][$i][$attrib] = $attribVal;

							}						
						}
						
						$d++;
						
						$_SESSION['store']['items'][$i]['value'] = $itemObj->calculate_value($item['value'],$quality);
						
					}
					$i++;
				}
			}
		}

		$softwareObj = new Software(array(
			'level'=>$storeObj->row['level'], 
			'in_store'=>'1'
			));
			
		$software_userObj = new Software_user;
		
		$skillObj = new Skill(array(
			'level'=>$storeObj->row['level'], 
			'in_store'=>'1'
			));
			
		$skill_userObj = new Skill_user;
		
		
		foreach ($softwareObj->data as $software) {
			$software_userObj->clear();
			$softwares[$software['software_id']] = $software;
			$software_userObj->load(array(
				'user_id'=>$_SESSION['user']['user_id'], 
				'software_id'=>$software['software_id']
				));
			
			
			if ($software_userObj->row) {
				
				$software_id = $software['software_id'];
			
				$softwares[$software_id]['version'] = $software_userObj->row['version'] + 1;
				$softwares[$software_id]['upgrade'] = true;
				
				$newValue = $softwareObj->calc_value(
					$software['damage'],
					$software['level'],
					$software_userObj->row['version']
					);
				
				
				
				$softwares[$software_id]['value'] = $newValue;
				
				$damage = $softwareObj->calc_damage(
					$software['damage'],
					$software['level'],
					$software_userObj->row['version']
					);
				
				$softwares[$software_id]['damage'] = $damage;
				
			}
		}
		
		foreach ($skillObj->data as $skill) {
		
			$skill_userObj->clear();
			$skills[$skill['skill_id']] = $skill;
			$skill_userObj->load(array(
				'user_id'=>$_SESSION['user']['user_id'],
				'skill_id'=>$skill['skill_id']
				));
			
			if ($skill_userObj->row) {
				//$skills[$skill['skill_id']]['version'] = $skill_userObj->row['version'];
				//$skills[$skill['skill_id']]['upgrade'] = true;
			}
		}

		
		//echo "<pre>";print_r($_SESSION['store']['items']);echo"</pre>";

		$store['items']['items'] = $_SESSION['store']['items'];
		$store['items']['softwares'] = $softwares;
		$store['items']['skills'] = $skills;
		
		$this->vars('attribs',$attribs);
		$this->vars('store',$store);
	}
}
?>