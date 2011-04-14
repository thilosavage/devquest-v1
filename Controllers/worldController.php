<?php
class worldController extends Controller {
	var $layout = '_world';
	var $facebook = '';
	
	function prep(){

		$fbvars['appId'] = site::fbapp_id;
		$fbvars['secret'] = site::fbapp_secret;
		$fbvars['cookie'] = true;
		$this->facebook = new Facebook($fbvars);
	
		//$this->cookie = Facebook::get_cookie();
		if ($this->view !== 'index' && !$_SESSION['user']) {
			$this->logout();
		}
		
		
	}

	function index(){

		unset(
			$_SESSION['skillsUp'],
			$_SESSION['store']['store_id'],
			$_SESSION['artifacts'],
			$_SESSION['has_artifacts'],
			$_SESSION['user']['quest']
			);
		
		$userObj = new User;
		
		$fbSession = $this->facebook->getSession();


		if ($fbSession){
			
			if ($_SESSION['user']) {
				$userObj->set['loc_id'] = settings::initial_home;
				$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			}
			else {
				$userObj->login($this->facebook);
			}
			
			$userObj->setOnline();
	
			
			
			$user_id = $userObj->save();

			
			if ($_SESSION['newUser']){
				// initial skill
				$skill_userObj = new Skill_user;
				$skill_userObj->set['skill_id'] = 3;
				$skill_userObj->set['user_id'] = $user_id;
				$skill_userObj->save();
				
				$questObj = new Quest(array('name'=>'tutorial'));
				$quest_userObj = new Quest_user;
				$quest_userObj->set['tasks'] = $questObj->row['tasks'];
				$quest_userObj->set['user_id'] = $user_id;
				$quest_userObj->set['quest_id'] = $questObj->row['quest_id'];
				$quest_userObj->save();
				
			}
			
			unset($_SESSION['newUser']);

			$userObj->clear();

			$userObj->setSession($user_id, settings::$attribs);

		}
		else {
			$this->logout();
		}
		
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

		foreach ($software_userObj->data as $softwareData){
		
			$cooldown = $softwareObj->data[$softwareData['software_id']]['cooldown'];
			$version = $softwareData['version'];
			$softwareObj->data[$softwareData['software_id']]['cooldown'] = $cooldown * $version;

		}
		

		$quest_userObj = new Quest_user(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'is_completed'=>'0'
			));
		
		if ($quest_userObj->row) {
		
			$questObj = new Quest($quest_userObj->row['quest_id']);
			
			$_SESSION['user']['quest'] = $quest_userObj->row;
			$_SESSION['user']['quest']['name'] = $questObj->row['name'];
			
			if ($questObj->row['name'] == 'tutorial') {
				$_SESSION['user']['quest']['is_tutorial'] = true;
			}
			

		}
		
		$data['skills'] = $skillObj->data;
		$data['softwares'] = $softwareObj->data;

		
		$this->vars('data',$data);
		
		$this->vars('action','Entering the game...');
		$this->vars('money',$_SESSION['user']['money']);
		$this->vars('exp',$_SESSION['user']['exp']);
		$this->vars('level',$_SESSION['user']['level']);
		$this->vars('hp',$_SESSION['user']['hp']);
		$this->vars('ram',$_SESSION['user']['ram']);
		$this->vars('max_ram',$_SESSION['user']['max_ram']);
		$this->vars('max_hp',$_SESSION['user']['max_hp']);

	}
	
	function logout(){
		//session_destroy();
		$this->redirect('index');
	}
	
	function ajax_worldMoverProcess($bearing){
		
		// reload bag to get rid of "sell" buttons
		if ($_SESSION['store']['store_id']) {
			unset($_SESSION['store']['store_id']);
			$reloadBag = true;
		}
		
		$user = new User($_SESSION['user']['user_id']);

		// loc handling
		$locObj = new Loc;
		$newLoc = $locObj->get_this_loc($_SESSION['user']['loc_id'],$bearing);
		$nextLoc = $locObj->get_next_loc($newLoc['loc_id'],$bearing);

		$rightLoc = $locObj->get_right_loc($newLoc['loc_id'],$bearing);
		$leftLoc = $locObj->get_left_loc($newLoc['loc_id'],$bearing);
	
	
		// quest
		if ($_SESSION['user']['quest']) {
			$questArr = json_decode($_SESSION['user']['quest']['tasks'], true);
			
			if ($questArr['loc:'.$newLoc['quest'].'-'.$bearing]){
			
				$quest['has_quest'] = true;
				$quest['path'] = $_SESSION['user']['quest']['name'].'/'.$newLoc['quest']."-".$bearing;
				
				$questArr['loc:'.$newLoc['quest'].'-'.$bearing] = 0;
				
				$_SESSION['user']['quest']['tasks'] = json_encode($questArr);
				
				$quest_userObj = new Quest_user(array(
					'user_id'=>$_SESSION['user']['user_id'],
					'quest_id'=>$_SESSION['user']['quest']['quest_id']
					));
				
				$quest_userObj->set['quest_user_id'] = $quest_userObj->row['quest_user_id'];
				$quest_userObj->set['tasks'] = $_SESSION['user']['quest']['tasks'];
				$quest_userObj->save();
				
				if ($_SESSION['user']['quest']['is_tutorial']) {
					if (file_exists(site::root."_images/locs/".$newLoc['loc_id'].$bearing.'T.jpg')) {
						$quest['tutorial_image'] = true;
					}
				}
			}
		}
		
		if ($nextLoc['level'] > $_SESSION['user']['level']) {
			$deadEnd = $nextLoc['level'];
		}
		
		$_SESSION['loc']['level'] = $newLoc['level'];
		
		$locSetter = array('loc_id'=>$newLoc['loc_id']);

		$user_locObj = new User_loc(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'loc_id'=>$newLoc['loc_id']
			));
		
		// artifacts
		if (!$user_locObj->data) {
			
			if ($newLoc['has_artifacts']) {
				
				$itemObj = new Item;
				$itemObj->load(array('loc_id'=>$newLoc['loc_id']));
				$custom_artifacts = $itemObj->data;
				$itemObj->clear();
				
				$artifacts['key'] = $itemObj->generate_artifacts($newLoc['level'],$custom_artifacts);
				
				
			}
			else {
				$artifacts = array();
			}
			$user_locObj->set['user_id'] = $_SESSION['user']['user_id'];
			$user_locObj->set['loc_id'] = $newLoc['loc_id'];
			$user_locObj->save();
			
		}
		
		if ($newLoc['has_artifacts']) {
			$artifacts['has_artifacts'] = true;
		}
		
		// job generator
		if ($newLoc['has_job']) {
			$jobObj = new Job(array('loc_id'=>$newLoc['loc_id']));
			if ($jobObj->row) {

				$job_userObj = new Job_user(array(
					'`user_id`'=>$_SESSION['user']['user_id'], 
					'`job_id`'=>$job['job_id']
					));
			
				if ($job_userObj->row) {
					$job = $jobObj->get_job($jobObj->row);
				}
				else {
					$job = $jobObj->render_job($job_userObj->row);
					$job['employed'] = true;
				}

				$job['is_job'] = true;

			}
		}
		
		
		// bot generator
		$botObj = new Bot;
		$bot_userObj = new Bot_user(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'loc_id'=>$newLoc['loc_id']
			));
			
		if ($bot_userObj->data){
			$botObj->load_bots($bot_userObj->data);
		}
		else if ($newLoc['has_bots']){
		
			$botObj->load(array('zone_id'=>$newLoc['loc_id']));

			if ($botObj->data) {
				$botObj->data = $botObj->data;
			}
			else {
				$botObj->data = $botObj->generate_bots($newLoc['level']);
			}
			$bot_userObj->set_bots($botObj->data, $newLoc['loc_id']);
		}
		
		if ($botObj->data){
			$bots['data'] = $botObj->data;
			$bots['has_bots'] = true;
		}
		
		// store generator
		$storeObj = new Store($locSetter);
		
		if ($storeObj->row){

			if ($questArr['store']) {
				$quest['has_quest'] = true;
				$quest['module'] = 'store';
				$questArr['store'] = 1;
			}

			$store = $storeObj->row;
			$store['is_store'] = true;

		}

		// gig generator
		if ($newLoc['has_gig']) {
			$gigObj = new Gig;
			$gigObj->use_id_values = false;
			$gigObj->load(array('loc_id'=>$newLoc['loc_id']));		

			$gig_userObj = new Gig_user(array(
				'`user_id`'=>$user->row['user_id'],
				'`loc_id`'=>$newLoc['loc_id']
				));
			
			$gigsCompleted = count($gig_userObj->data);
			
			$gig = $gigObj->data[$gigsCompleted];
			
			$gig['data'] = $gigObj->get_gig($gig);
			$gig['data']['desc'] = $gig['desc'];
			$gig['is_gig'] = true;

		}

		// calculate new energy
		$energy = $_SESSION['user']['energy'] - 1;
		
		// save user data
		$user->set['user_id'] = $_SESSION['user']['user_id'];
		$user->set['energy'] = $energy;
		$user->set['last_loc_id'] = $locObj->lastLoc;
		
		
		
		$user->set['loc_id'] = $newLoc['loc_id'];
		
		
		$user->set['lastEvent'] = time();
		//$user->set['quest'] = json_encode($questArr);
		$user->save();
		
		// save session
		$_SESSION['user']['energy'] = $energy;
		$_SESSION['user']['loc_id'] = $newLoc['loc_id'];
		
		// loc info
		$this->vars('desc', $loc->row['desc']);
		$this->vars('name', $loc->row['name']);
		
		// hud
		//$this->vars('exp',$exp);
		//$this->vars('money',$money);
		$this->vars('energy',$energy);
		
		// loc specs
		$this->vars('gig',$gig);
		$this->vars('job',$job);		
		$this->vars('store',$store);
		$this->vars('bots',$bots);

		$this->vars('deadEnd',$deadEnd);
		
		// directions
		$this->vars('bearing',$bearing);
		$this->vars('newLoc',$newLoc);
		$this->vars('nextLoc',$nextLoc);
		$this->vars('rightLoc',$rightLoc);
		$this->vars('leftLoc',$leftLoc);
		
		// other
		$this->vars('quest',$quest);
		$this->vars('reloadBag',$reloadBag);
		
		$this->vars('artifacts',$artifacts);

	}	
	
	function ajax_worldTurnProcess(){
		
		if ($_SESSION['store']['store_id']) {
			unset($_SESSION['store']['store_id']);
			$reloadBag = true;
			
		}

		
		$dir = $_POST['dir'];
		$bearing = $_POST['bearing'];
		$_SESSION['bearing'] = $bearing;

		if ($bearing == 'n' && $dir=='l'){$abearing = 'w';}
		if ($bearing == 's' && $dir=='l'){$abearing = 'e';}
		if ($bearing == 'e' && $dir=='l'){$abearing = 'n';}
		if ($bearing == 'w' && $dir=='l'){$abearing = 's';}
		if ($bearing == 'n' && $dir=='r'){$abearing = 'e';}
		if ($bearing == 's' && $dir=='r'){$abearing = 'w';}
		if ($bearing == 'e' && $dir=='r'){$abearing = 's';}
		if ($bearing == 'w' && $dir=='r'){$abearing = 'n';}
		
		$locObj = new Loc($_SESSION['user']['loc_id']);
		$thisLoc = $locObj->row;
		$locObj->clear();

		$nextLoc = $locObj->get_next_loc($_SESSION['user']['loc_id'],$abearing);
		// quest
		
		// quest
		if ($_SESSION['user']['quest']) {
			$questArr = json_decode($_SESSION['user']['quest']['tasks'], true);
			
			if ($questArr['loc:'.$thisLoc['quest'].'-'.$abearing]){
				$quest['has_quest'] = true;
				$quest['path'] = $_SESSION['user']['quest']['name'].'/'.$thisLoc['quest']."-".$abearing;
				$questArr['loc:'.$thisLoc['quest'].'-'.$abearing] = 0;
				
				$_SESSION['user']['quest']['tasks'] = json_encode($questArr);
				
				if ($_SESSION['user']['quest']['is_tutorial']) {
					if (file_exists(site::root."_images/locs/".$thisLoc['loc_id'].$abearing.'T.jpg')) {
						$quest['tutorial_image'] = true;
					}
				}				

				$quest_userObj = new Quest_user(array(
					'user_id'=>$_SESSION['user']['user_id'],
					'quest_id'=>$_SESSION['user']['quest']['quest_id']
					));
				
				$quest_userObj->set['quest_user_id'] = $quest_userObj->row['quest_user_id'];
				$quest_userObj->set['tasks'] = $_SESSION['user']['quest']['tasks'];
				$quest_userObj->save();				
				
			}
			

		}
		
		if ($nextLoc['level'] > $_SESSION['user']['level']) {
			$deadEnd = $nextLoc['level'];
		}
		
		
	/*
		if ($_SESSION['has_artifacts']) {
			
			$itemObj = new Item;
			
			$artifacts = $itemObj->generate_artifacts($_SESSION['loc']['level']);

			$artifacts['has_artifacts'] = true;
			unset($_SESSION['has_artifacts']);
		}
*/
		$storeObj = new Store(array('loc_id'=>$_SESSION['user']['loc_id']));
		
		if ($storeObj->row){
			
			$store = $storeObj->row;
			$store['is_store'] = true;

		}

		
		$this->vars('store',$store);
		$this->vars('junk','');
		$this->vars('quest',$quest);
		$this->vars('nextLoc',$nextLoc);
		$this->vars('bearing',$abearing);
		
		$this->vars('loc_id',$thisLoc['loc_id']);
		
		$this->vars('deadEnd',$deadEnd);

		$this->vars('reloadBag',$reloadBag);
	
	}
	
	function locedit() {
	
		$loc = new Loc('all');
		
		$locs = $loc->data;
		
		$loc->clear();

		foreach ($locs as $z) {
			$locS = new Loc;
			$locS->set['loc_id'] = $z['loc_id'];
			$locS->set['type'] = 'road';
			//$bah = $locS->save();
		}
	
	}
	
	function ajax_worldSleepStart(){
	
		unset($_SESSION['skillsUp'],
			$_SESSION['store']
			);
	
		$userObj = new User($_SESSION['user']['user_id']);
		
		$energy = $_SESSION['user']['max_energy'];
		$hp = $_SESSION['user']['max_hp'];
		$ram = $_SESSION['user']['max_ram'];
		
		$userObj->set['user_id'] = $_SESSION['user']['user_id'];
		$userObj->set['energy'] = $energy;
		$userObj->set['hp'] = $hp;
		$userObj->set['ram'] = $ram;
		$userObj->save();
		
		$_SESSION['user']['energy'] = $energy;
		$_SESSION['user']['hp'] = $hp;
		$_SESSION['user']['ram'] = $ram;
		
		$this->vars('energy',$energy);
		$this->vars('hp',$hp);
		$this->vars('ram',$ram);
		
		$bot_userObj = new Bot_user;
		
		
		$bot_userObj->custom(
			'DELETE FROM bot_user WHERE user_id = %s', $_SESSION['user']['user_id']
			);

		$user_locObj = new User_loc;
		
		$bot_userObj->custom(
			'DELETE FROM user_loc WHERE user_id = %s', $_SESSION['user']['user_id']
			);			
	}
	
	function ajax_worldReviveProcess($loc_id){
	
		unset($_SESSION['skillsUp']);


		$locObj = new Loc($_SESSION['user']['loc_id']);
		
		$_SESSION['user']['bearing'] = settings::initial_bearing;
		$_SESSION['user']['loc_id'] = settings::initial_home;

		
		if ($_SESSION['user']['quest']) {
			$questArr = json_decode($_SESSION['user']['quest']['tasks'], true);

			if ($questArr['loc:'.$locObj->row['quest'].'-'.$_SESSION['user']['bearing']]) {
				$quest['has_quest'] = true;
				$quest['path'] = $_SESSION['user']['quest']['name'].'/'.$locObj->row['quest']."-".$_SESSION['user']['bearing'];
				$questArr['intro'] = 0;
			}
			
			$quest_userObj = new Quest_user(array(
				'user_id'=>$_SESSION['user']['user_id'],
				'quest_id'=>$_SESSION['user']['quest']['quest_id']
				));
			
			$quest_userObj->set['quest_user_id'] = $quest_userObj->row['quest_user_id'];
			$quest_userObj->set['tasks'] = $_SESSION['user']['quest']['tasks'];
			$quest_userObj->save();			
			
		}

		
		$userObj = new User($_SESSION['user']['user_id']);
		
		$rent = pow($_SESSION['user']['level'],3);
		
		$newMoney = $_SESSION['user']['money'] - $rent;
		
		
		
		if ($newMoney < 0) {
			$newMoney = 0;
			$rent = $_SESSION['user']['money'];
		}
		
		$_SESSION['user']['money'] = $newMoney;
		
		$userObj->set['user_id'] = $_SESSION['user']['user_id'];
		$userObj->set['energy'] = $_SESSION['user']['max_energy'];
		$userObj->set['hp'] = $_SESSION['user']['max_hp'];
		$userObj->set['money'] = $_SESSION['user']['money'];
		$userObj->set['loc_id'] =$_SESSION['user']['loc_id'];
		
		$userObj->save();
		
		

		$this->vars('loc', $locObj->row);
		
		$this->vars('name', $locData['name']);
		$this->vars('desc', $locData['desc']);
		
		$this->vars('hp', $userObj->set['hp']);
		$this->vars('energy', $userObj->set['energy']);
		
		$this->vars('rent',$rent);
		$this->vars('money',$newMoney);
		
		$this->vars('directions',$directions);
		
		$this->vars('quest',$quest);
	
	}
	

	
	function ajax_worldItemPickup($key){
		
		$userObj = new User($_SESSION['user']['user_id']);
		
		$artifacts = $_SESSION['artifacts'][$key];
		
		$error = 0;

		$item_userObj = new Item_user;
		$itemObj = new Item;
		
		foreach ($artifacts as $artifact) {
		
			$item_userObj->clear();
			
			foreach (settings::$attribs as $attrib) {
				$item_userObj->set[$attrib] = $artifact[$attrib];
			}
			
			if (!$error){
				
				
				$item_userObj->set['user_id'] = $_SESSION['user']['user_id'];
				$item_userObj->set['item_id'] = $artifact['item_id'];
				$item_userObj->set['value'] = $artifact['value'];
				$item_userObj->save();

			}
		
		}

		$this->vars('error',$error);
		$this->vars('key',$key);
		$this->vars('artifacts',$artifacts);

		unset($_SESSION['artifacts'][$key]);

	}
	
	function ajax_worldLootPickup($key){
		
		$userObj = new User($_SESSION['user']['user_id']);
		
		$artifact = $_SESSION['artifacts'][$key];
		
		$error = 0;

		$item_userObj = new Item_user;
		$itemObj = new Item;
		
		foreach (settings::$attribs as $attrib) {
			$item_userObj->set[$attrib] = $artifact[$attrib];
		}
		
		if (!$error){
			
			
			$item_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$item_userObj->set['item_id'] = $artifact['item_id'];
			$item_userObj->set['value'] = $artifact['value'];
			$item_userObj->save();

		}


		$this->vars('error',$error);
		$this->vars('key',$key);
		$this->vars('artifacts',$artifacts);

		unset($_SESSION['artifacts'][$key]);

	}
	
	function ajax_worldMoneyPickup($key){
		
		$userObj = new User;
		
		$cash = $_SESSION['cash'][$key];
		
		$newMoney = $_SESSION['user']['money'] + $cash;
		
		$userObj->set['user_id'] = $_SESSION['user']['user_id'];
		$userObj->set['money'] = $newMoney;
		$userObj->save();
		
		$_SESSION['user']['money']  = $newMoney;
		
		$this->vars('key',$key);
		$this->vars('money',$cash);
		$this->vars('newMoney',$newMoney);
		$this->vars('error',$error);
		
		unset($_SESSION['cash'][$key]);

	}	
}
?>