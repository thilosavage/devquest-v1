<?php
class fightController extends Controller {

	function ajax_fightMethodUse($target_id){
		
		$userObj = new User($_SESSION['user']['user_id']);
		$skill_userObj = new Skill_user;
		$skillObj = new Skill;
		
		$level = $_SESSION['user']['level'];
		
		if ($_POST['method'] == 'skill'){
		
			$userObj->set['ram'] = $userObj->row['ram'];
		
			$skill_userObj->load(array(
				'skill_id'=>$_POST['method_id'], 
				'user_id'=>$_SESSION['user']['user_id'])
				);
				
			if ($skill_userObj->row){
				$skillObj->load($_POST['method_id']);
				
				$skill_user_id = $skill_userObj->row['skill_user_id'];
				
				$ability = $skillObj->get_ability($skill_userObj->row['exp']);
				
				$setdamage = $skillObj->calc_damage(
					$ability['mod'], 
					$skillObj->row['damage'], 
					$skillObj->row['level'],
					$_SESSION['bugs'][$target_id]['defense']
					);
					
					
				// i take anxiety pills.. i chop them up into pieces first and that helps me not worry about the little things
				

				$damage = rand($setdamage['min'],$setdamage['max']);
				
				$cooldown = $skillObj->calc_cooldown(
					$skillObj->row['damage'], 
					$ability['mod'], 
					$skillObj->row['level']
					);

				$newExp = $skill_userObj->row['exp'] + $damage;

				$_SESSION['skillsUp'][$skill_user_id]['exp'] = $newExp;
				$_SESSION['skillsUp'][$skill_user_id]['name'] = $skillObj->row['name'];

			}
		}
		if ($_POST['method'] == 'software'){
		
			$software_userObj = new Software_user(array(
				'software_id'=>$_POST['method_id'], 
				'user_id'=>$_SESSION['user']['user_id'])
				);
				
			if ($software_userObj->row){
				$softwareObj = new Software($_POST['method_id']);
				
				$ramUsed = $softwareObj->row['ram'];
				
				if ($ramUsed <= $_SESSION['user']['ram']) {
				
					$setdamage = $softwareObj->calc_damage(
						$softwareObj->row['damage'], 
						$softwareObj->row['level'], 
						$software_userObj->row['version']
						);
					
					$damage = rand($setdamage['min'],$setdamage['max']);				

					$cooldown = $softwareObj->row['cooldown'];
					
					$userObj->set['ram'] = $_SESSION['user']['ram'] - $ramUsed;
					$_SESSION['user']['ram'] = $userObj->set['ram'];				
				
				}
				
			
				else {
				
					$damage = '0';
					$userObj->set['ram'] = $_SESSION['user']['ram'];		
					$ramUsed = '0';
					
				}
			}
		}
		

		$bug_name = $_SESSION['bugs'][$target_id]['name'];

		if ($_SESSION['bugs'][$target_id]['hp_left'] > 0) {
		
			$_SESSION['bugs'][$target_id]['hp_left']  = $_SESSION['bugs'][$target_id]['hp_left'] - $damage;
			
			if ($_SESSION['bugs'][$target_id]['hp_left'] <= 0) {
				$_SESSION['bugs'][$target_id]['hp_left'] = 'dead';
				
				$itemObj = new Item;
				
			}
		}
		
		$clear = '1';
		foreach ($_SESSION['bugs'] as $bug){
			if ($bug['hp_left'] > 0){
				$clear = '0';
			}
		}
		
		$results = '';
		if ($clear){
		
		
			// quest
			if ($_SESSION['user']['quest']) {
				$questArr = json_decode($_SESSION['user']['quest']['tasks'], true);
				

				if ($questArr['clear:'.$_SESSION['bot_id']]){
				
					$quest['has_quest'] = true;
					$quest['path'] = $_SESSION['user']['quest']['name'].'/_clear-'.$_SESSION['bot_id'];
					$questArr['intro'] = 0;
				}
			}
		
		
			$botObj = new Bot($_SESSION['bot_id']);
			$bot = $botObj->row;
			
			$bugObj = new Bug($_SESSION['bugs'][$target_id]['bug_id']);
			
			$itemObj->load(array('bot_id'=>$bot['bot_id']));
			$custom_artifacts = $itemObj->data;
			$itemObj->clear();
			
			$artifacts = $itemObj->generate_artifacts($bugObj->row['level'],$custom_artifacts);

			$cash = $itemObj->generate_cash($bugObj->row['level']);

			$vals = array(
				'user_id'=>$_SESSION['user']['user_id'],
				'loc_id'=>$_SESSION['user']['loc_id'],
				'bot_id'=>$_SESSION['bot_id']
			);
			
			// clear bot
			// unnecessary because bot is cleared once clicked
			//$bot_userObj = new Bot_user($vals);
			//$bot_userObj->set['bot_user_id'] = $bot_userObj->row['bot_user_id'];
			//$bot_userObj->set['is_clear'] = '1';
			//$bot_userObj->save();
			
			$expUp = 5;
			
			$exp = $_SESSION['user']['exp'] + $expUp;
			$energy = $_SESSION['user']['energy'] - 1;
			
			$levelObj = new Level;
			$newLevel = $levelObj->get_levelup($exp);
			
			
			
			if ($newLevel) {
				//$userObj->set['level'] = $newLevel;
				$_SESSION['user']['level'] = $newLevel;
				
				$level = $newLevel['newLevel'];
				$levelUp = $newLevel['newLevel'];
				
			}

			
			
			
			if ($_SESSION['skillsUp']) {
			
				foreach ($_SESSION['skillsUp'] as $skill_user_id => $x){
				
					$skill_userIDs[] = $skill_user_id;
					
				}
				
				$skill_userObj->clean();
				$skill_userObj->load($skill_userIDs);
				
				foreach ($_SESSION['skillsUp'] as $skill_user_id => $abilityData){
				
					$ability = $skillObj->get_ability($abilityData['exp']);

					if ($ability['name'] !== $skill_userObj->data[$skill_user_id]['ability']){
						$skillsUp[] = array(
							'ability'=>$ability['name'],
							'skill'=>$abilityData['name']
							);
					}				

					$skill_userObj->clean();
					$skill_userObj->set['skill_user_id'] = $skill_user_id;
					$skill_userObj->set['ability'] = $ability['name'];
					$skill_userObj->set['exp'] = $abilityData['exp'];
					$skill_userObj->save();
					
				}
				unset($_SESSION['skillsUp']);
				
			}
			
			
			
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['exp'] = $exp;
			//$userObj->set['money'] = $money;
			$userObj->set['energy'] = $energy;
			$userObj->save();
			
			
			$_SESSION['user']['exp'] = $exp;
			//$_SESSION['user']['money'] = $money;
			$_SESSION['user']['energy'] = $energy;
			
			
			$results .= $botObj->row['thanks'];
			
		}
		else if ($_POST['method'] == 'software'){
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->save();
		}
		
		$bugs = $_SESSION['bugs'][$target_id];
		
		$this->vars('expUp',$expUp);
		
		// hud
		$this->vars('exp',$exp);
		$this->vars('energy',$energy);
		$this->vars('level',$level);
		
		$this->vars('ram',$userObj->set['ram']);
		
		$this->vars('clear',$clear);
		$this->vars('response',$response);
		$this->vars('bugs',$bugs);
		$this->vars('results',$results);
		$this->vars('bot',$bot);
		
		$this->vars('level',$_SESSION['user']['level']);
		$this->vars('levelUp',$levelUp);
		
		$this->vars('skillsUp',$skillsUp);
		
		$this->vars('cooldown',$cooldown);
		
		$this->vars('artifacts',$artifacts);
		$this->vars('cash',$cash);
		
		$this->vars('damage',$damage);
		
		$this->vars('quest',$quest);
		
		
	}
	
	
	function ajax_fightBugAttack($bug_id){
	
		$userObj = new User($_SESSION['user']['user_id']);
	
		$bugObj = new Bug($bug_id);
		
		$botObj = new Bot($_SESSION['bot_id']);
		
		$damage = $bugObj->row['damage'];

		$setDamage = $bugObj->row['damage'];
		$margin = $setDamage * .15;
		$damage = ceil(rand($setDamage - $margin,$setDamage + $margin));

		$newBattery = $userObj->row['hp'] - $damage;
		
		if ($newBattery <= 0 ) {
		
			unset($_SESSION['skillsUp']);
			$this->vars('dead',true);
		
		}
		else {
		
			$_SESSION['user']['hp'] = $newBattery;
		
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['hp'] = $newBattery;
			$userObj->save();	
			$this->vars('dead',false);
		}
		
		$this->vars('hp',$_SESSION['user']['max_hp']);
		$this->vars('damage',$damage);
		$this->vars('hp_left',$newBattery);
		$this->vars('bot',$botObj->row);
	
	}
	
	function ajax_fightSkillsLoad() {
	
		$skill_userObj = new Skill_user(array(
			'user_id'=>$_SESSION['user']['user_id']
			));
		
		foreach ($skill_userObj->data as $skillData) {
			$skill_ids[] = $skillData['skill_id'];	
		}

		$software_userObj = new Software_user(array(
			'user_id'=>$_SESSION['user']['user_id']
			));
			
		foreach ($software_userObj->data as $softwareData) {
			$software_ids[] = $softwareData['software_id'];
		}
		
		$skillObj = new Skill($skill_ids);
		$softwareObj = new Software($software_ids);


		foreach ($software_userObj->data as $softwareData) {
		
			$cooldown = $softwareObj->data[$softwareData['software_id']]['cooldown'];
			$cooldown = $softwareObj->calc_cooldown(
				$cooldown,
				$softwareData['level'],
				$softwareData['version']
				);
			
			$softwareObj->data[$softwareData['software_id']]['cooldown'] = $cooldown;
			
		}
		
		$data['skills'] = $skillObj->data;
		$data['softwares'] = $softwareObj->data;
		
		$this->vars('data',$data);
		
		
	}
}
?>