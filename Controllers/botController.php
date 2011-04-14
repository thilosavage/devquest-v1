<?php

class botController extends Controller {

	function ajax_botTalkOpen($bot_id){
		
		$attribs = settings::$attribs;
		
		unset($_SESSION['skillsUp'],
			$_SESSION['sells'],
			$_SESSION['cash'],
			$_SESSION['bar_width']
			);
		
		$_SESSION['bot_id'] = $bot_id;
		
		$botObj = new Bot($bot_id);
		$userObj = new User($_SESSION['user']['user_id']);
		
		// quest
		if ($_SESSION['user']['quest']) {
			$questArr = json_decode($_SESSION['user']['quest']['tasks'], true);
			

			if ($questArr['bot:'.$bot_id]){
			
				$quest['has_quest'] = true;
				$quest['path'] = $_SESSION['user']['quest']['name'].'/_bot-'.$bot_id;
				$questArr['intro'] = 0;
			}
		}
		
		$r = mt_rand(1,5);
		if ($r == 5) {
			$responseType = 'sell';
		}
		else {
			$responseType = 'fight';
		}
		
		$bot = $botObj->row;

		$bugObj = new Bug(array(
			'bot_id'=>$bot_id
			));
		
		if ($responseType == 'fight' || $bugObj->data){
		
			$responseType = 'fight';

			
			if ($bugObj->data) {
				$default_bugs = $bugObj->data;
				
				foreach ($default_bugs as $k => $bug) {
				
					$bugs[$k] = $bug;
					$bugs[$k]['hp_left'] = $bug['hp'];
					$bugs[$k]['sbug_id'] = $k;
					
				}
				

			}
			else {
				$bugs = $bugObj->generate_bugs($bot['level']);
			}

			$_SESSION['bugs'] = $bugs;
			
			$is_fight = true;
			

			
			$this->vars('bugs',$bugs);
			
			
		}
		else if ($responseType == 'sell') {
			
			$sellTypes = array('Item','Skill','Software');
			
			foreach ($sellTypes as $sellType){
			
				$isSell = mt_rand(1,1);
				//$isSell = '1';
				if ($isSell == 1){
					$sellObj = new $sellType;
					
					if ($sellType == 'Item') {
						
						$i = 0;
						$sellObj->get_random($botObj->row['level']);
						
						$item = $sellObj->row;
						
						$_SESSION['sells']['item'] = $item;
						
						foreach ($attribs as $attrib){
							$attribVal = $item[$attrib];
							
							$r = mt_rand(1,100);
							
							if ($attribVal > 0) {

								$_SESSION['sells']['item'][$attrib] = $attribVal;
								
							}
						}
							
						if (!$item['cumulative']) {

							foreach ($attribs as $attrib){
								$attribVal = $item[$attrib];
								
								$r = mt_rand(1,100);
								
								$topMargin = $item['level'];
								$bottomMargin = $item['level'] - $item['level'] - $item['level'];
								
								if ($attribVal > 0) {
								
									$valueModifier = mt_rand($attribVal+$bottomMargin, $attribVal+$topMargin);
								
									if ($r > 0) {
										$attribVal = $attribVal * 15;
										$_SESSION['sells']['item']['value'] = $item['value'] + $attribVal * 5;
									}
									else if ($r > 80) {
										$attribVal = $attribVal * 3;
										$_SESSION['sells']['item']['value'] = $item['value'] + $attribVal * 2;
									}
									else if ($r > 1) {
										$attribVal = $attribVal * 2;
										$_SESSION['sells']['item']['value'] = $item['value'] + $attribVal;
									}
									
									$_SESSION['sells']['item'][$attrib] = $attribVal;

								}						

							}							

						}
					}


					else {
						$sellObj->random($botObj->row['level']);
						$_SESSION['sells'][strtolower($sellType)] = $sellObj->row;					
					}
				}
			
			}
		
			$this->vars('sells',$_SESSION['sells']);
	
		}

		$bot_userObj = new Bot_user(array(
			'bot_id'=>$bot_id,
			'user_id'=>$_SESSION['user']['user_id'],
			'loc_id'=>$_SESSION['user']['loc_id']
			));
		
		$bot_userObj->set['bot_user_id'] = $bot_userObj->row['bot_user_id'];
		$bot_userObj->set['is_clear'] = 1;
		$bot_userObj->save();
		

		
		$this->vars('bot',$bot);
		
		$this->vars('responseType',$responseType);
		
		$this->vars('hp_left',$userObj->row['hp']);	
		$this->vars('max_hp',$_SESSION['user']['max_hp']);	
		
		$this->vars('quest',$quest);

	}
}
?>