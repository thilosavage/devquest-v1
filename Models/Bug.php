<?php
class Bug extends Model {

	protected $table = 'bug';
	protected $id_field = 'bug_id';
	protected $name_field = 'bugname';
	protected $order_by = 'bug_id ASC';

	
	function generate_bugs($level){

		$rand = rand(1,1);

		$i = 1;
		while ($i <= $rand) {
			$this->clear();
			$this->custom('SELECT * FROM bug t JOIN 
				(SELECT(FLOOR(max(bug_id) * rand())) as maxid FROM bug) 
				as tt on t.bug_id >= tt.maxid WHERE level=%s LIMIT 1',
				$level);

			$newLevel = $this->row['level'] + rand(0,1);

			$this->row['hp'] = $this->row['hp'] + pow($newLevel,2);
			
			$bugs[$i] = $this->row;
			$bugs[$i]['level'] = $newLevel;
			$bugs[$i]['hp_left'] = $this->row['hp'];
			$bugs[$i]['sbug_id'] = $i;
			$i++;
	
		}
		
		return $bugs;
		
	}
}
?>