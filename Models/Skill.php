<?php 
class Skill extends Model {

	protected $table = 'skill';
	protected $id_field = 'skill_id';
	protected $name_field = 'name';
	protected $order_by = 'sort ASC';
	
	function random($level,$number='1'){
		
		$this->custom('SELECT * FROM skill t JOIN 
		(SELECT(FLOOR(max(skill_id) * rand())) as maxid FROM skill) 
		as tt on t.skill_id >= tt.maxid WHERE level=%s LIMIT %s',
		$level,$number);

	}
	
	function get_abilitys(){
	
		$abilitys[1] = 'Noob';
		$abilitys[400] = 'Amateur';
		$abilitys[4500] = 'Novice';
		$abilitys[20000] = 'Intermediate';
		$abilitys[100000] = 'Pro';
		$abilitys[1000000] = 'Expert';
		$abilitys[10000000] = 'Master';
		$abilitys[100000000] = 'Maven';
		
		return $abilitys;
	
	}
	
	function get_ability($exp){
		$abilitys = $this->get_abilitys();
		$i = 1;
		foreach ($abilitys as $k => $ability){

			if ($exp >= $k) {
				$currentAbility['name'] = $ability;
				$currentAbility['power'] = $i;
			}
			$i++;
		}
		return $currentAbility;				
	}
	
	function abilityToNumber($ability){
	
		$abilitys = array_flip($this->get_abilitys());
		
		return $abilitys[$ability];
		
	
	}
	function numberToAbility($number){
	
		$abilitys = $this->get_abilitys();
		
		return $abilitys[$number];
		
	}

	
	function calc_damage($ability,$damage,$level,$defense){
		
		$damage = $damage - $defense;
		
		if ($damage <= 0){
			$setdamage = 0;
			$margin = 0;
		}
		else {
			$ab = strlen($ability * .1);
			$a = $ab * $ab;
			$setdamage = ($a * $ab * $damage * $level / 2 + $ab + 10) * pow($ab,2) /$ab*$ab * .1 * 2;
			$margin = $setdamage * .12;
		}

		$dam['min'] = floor($setdamage - $margin);
		$dam['max'] = ceil($setdamage + $margin);

		return $dam;
	}
	
	
	function calc_cooldown($ability,$damage,$level){

		$ab = strlen($ability * .1);
		$a = $ab * $ab;
		
		return floor($cooldown/100 + $a*$ab*90*$level+1000);
	
	}	
	
}
?>