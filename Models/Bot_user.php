<?php
class Bot_user extends Model {

	protected $table = 'bot_user';
	protected $id_field = 'bot_user_id';
	protected $name_field = 'user_id';
	protected $order_by = 'time ASC';
	
	function set_bots($bots, $loc_id){
		if ($bots) {
			foreach ($bots as $bot){
				$this->clear();
				$this->set['bot_id'] = $bot['bot_id'];
				$this->set['user_id'] = $_SESSION['user']['user_id'];
				$this->set['loc_id'] = $loc_id;
				$this->set['time'] = time();
				$this->save();
			}
		}
		
	}
	
}
?>