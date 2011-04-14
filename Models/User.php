<?php 
class User extends Model {

	protected $table = 'user';
	protected $id_field = 'user_id';
	protected $name_field = 'name';
	protected $order_by = 'user_id DESC';
	
	function login($facebook){
	
		$fbme = $facebook->api('me');
		$this->load(array('`fbid`'=>$fbme['id']));
	
		
		if (!$this->row){
			$this->_newUser($fbme,$facebook);
		}
		else {
			$this->set['user_id'] = $this->row['user_id'];
			$this->set['loc_id'] = settings::initial_home;
		}
	}
	
	function _newUser($fbme, $facebook){
		
		$uid = $facebook->getUser();
		$token = $facebook->getAccessToken();
		$bah = $facebook->api($uid.'/friends?access_token='.$token);
		$i = 0;
		
		$botObj = new Bot;
		
		$hi = array(
			'Hey whats up? Help me with my computer dammit.',
			'Plz Hulp LOL.',
			'Hi there. My computer sucks. Help me and I will give you some cash.',
			'You look smart. Could you help me out?',
			'I think I have viruses or something. take a look if you want.'
		);

		
		$thanks = array(
			'Thanks so much!',
			'You da man!',
			'Now I can look at porn!',
			'Sweet bro, whered you learn that stuff?',
			'Awesome! It works! WTF! YAY'
		);

		
		$fail = array(
			'shit man, I thought u were good',
			'Noob',
			'U suck',
			'Nevermind Ill just take it to geek squad',
			'Ya I think i will just buy a new one'
		);
		
		foreach ($bah['data'] as $friend){
			if ($i < 5){
				
				//$randHi = rand(0,$hiCount);
				//$randThx = rand(0,$thxCount);
				//$randFail = rand(0,$failCount);
				
				//echo "<img src='https://graph.facebook.com/".$friend['id']."/picture/?type=large'>";
				$botObj->clear();
				$botObj->set['name'] = $friend['name'];
				$botObj->set['message'] = $hi[$i];
				$botObj->set['thanks'] = $thanks[$i];
				$botObj->set['fail'] = $fail[$i];
				$botObj->set['level'] = rand(1,1);
				$botObj->set['user_id'] = $fbme['id'];
				$botObj->set['fbid'] = $friend['id'];
				$fid = $botObj->save();

			}
			$i++;

		}
		

		$this->set['fbid'] = $fbme['id'];
		$this->set['name'] = $fbme['name'];
		$this->set['money'] = settings::initial_money;
		$this->set['loc_id'] = settings::initial_home;
		
		$this->set['energy'] = settings::initial_max_energy;
		$this->set['max_energy'] = settings::initial_max_energy;
		
		$this->set['hp'] = settings::initial_max_hp;
		$this->set['max_hp'] = settings::initial_max_hp;				
		
		//$this->set['battery'] = settings::initial_max_battery;
		//$this->set['max_battery'] = settings::initial_max_battery;
		
		$this->set['ram'] = settings::initial_max_ram;
		$this->set['max_ram'] = settings::initial_max_ram;		
		
		
		$this->set['demo'] = json_encode(array('intro'=>1, 'fight'=>1, 'world'=>1,'job'=>1,'gig'=>1));

		//$user_id = $this->save();

		$_SESSION['newUser'] = 1;
		
	}
	
	function verifyNewUser($user) {
	
		if (!preg_match("/[^a-zA-Z0-9]/", $user)){
		
			$this->values = array('name'=>$user);
			$this->load();
			if ($this->row){
				$error = true;
				$_SESSION['message'] = "Username taken";
			}
			
		}
		else {
			$_SESSION['message'] = "Invalid username. User only letters and numbers.";
			$error = true;
		}
		
		return $error?false:true;
	}
	
	function transferMoney($switch,$amount){

		$this->data = $this->row;

		if ($switch == '-'){
			$this->data['money'] = $this->data['money'] - $amount;
		}
		if ($switch == '+'){
			$this->data['money'] = $this->data['money'] + $amount;
		}
		//$this->save();
	}

	function setOnline(){
		$this->set['online'] = '1';
		$this->set['lastEvent'] = time();
	}
	
	function fbsave(){
		$old_id_field = $this->id_field;
		$this->id_field = 'fbid';
		$this->save();
		$this->id_field = $old_id_field;
	}
	
	function setSession($user_id, $attribs) {
		$this->load($user_id);
		
		
		
		$itemObj = new Item(array('user_id'=>$user_id));
		
		$item_userObj = new Item_user(array(
			'user_id'=>$user_id,
			'equipped'=>'1'
			));
		
		foreach ($item_userObj->data as $iuo){
		
			$item_ids[] = $iuo['item_id'];
		
		}
		
		$itemObj = new Item($item_ids);
		
		foreach ($itemObj->data as $item) {
			foreach ($attribs as $attrib){
				$this->row[$attrib] = $this->row[$attrib] + $item[$attrib];
			}
		}
		
		$_SESSION['user'] = $this->row;

	}
	


}
?>