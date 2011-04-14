<?php 
class Software extends Model {

	protected $table = 'software';
	protected $id_field = 'software_id';
	protected $name_field = 'name';
	protected $order_by = 'software_id DESC';
	
	
	function random($level,$number='1'){
		
		$this->custom('SELECT * FROM software t JOIN 
		(SELECT(FLOOR(max(software_id) * rand())) as maxid FROM software) 
		as tt on t.software_id >= tt.maxid WHERE level=%s LIMIT %s',
		$level,$number);

	}
	
	function calc_value($damage,$level,$version){
	
		return floor($damage*2 + pow($version,4)/3*$level);

	}
	
	function calc_damage($damage,$level,$version){
		
		$setdamage = floor($damage*$version+pow($level,2)/3+pow($version,3)/4);
		
		$margin = $setdamage * .1;

		//echo $setdamage."<--";
		
		$dam['min'] = floor($setdamage - $margin);
		$dam['max'] = ceil($setdamage + $margin + 4);

		
		return $dam;
		
	}
	
	
	function calc_cooldown($cooldown,$level,$version){
	
		
		return floor($cooldown/1000 + pow($version,4)/3*$level);
	
	}
	
}
?>