<?php
class Bot extends Model {

	protected $table = 'bot';
	protected $id_field = 'bot_id';
	protected $name_field = 'name';
	protected $order_by = 'level ASC';
	
	
	function generate_bots($level){

		$bots = array();
	
		$rand = rand(3,4);
	
		$i = 1;
		while ($i <= $rand) {
			$this->clear();
			$this->custom('SELECT * FROM bot t JOIN 
				(SELECT(FLOOR(max(bot_id) * rand())) as maxid FROM bot) 
				as tt on t.bot_id >= tt.maxid WHERE level=%s LIMIT 1',
				$level);
			$i++;
			
			if (!in_array($this->row['bot_id'],$bots)) {
				$bots[$this->row['bot_id']] = $this->row;
			}

	
		}

		
		return $bots;
		
		
	}
	
	function load_bots($bots){
		foreach ($bots as $tempBot){
			if (!$tempBot['is_clear']) {
				$botsToLoad[] = $tempBot['bot_id'];
			}
		}
		if ($botsToLoad){
			$this->load($botsToLoad);
		}	
	}
	
	
}
?>