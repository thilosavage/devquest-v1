<?php
class skillController extends Controller {

	function ajax_skillBuyProcess($skill_id){
	
		$error = 0;
	
		$skillObj = new Skill($skill_id);
		$userObj = new User($_SESSION['user']['user_id']);


		if ($skillObj->row['value'] > $userObj->row['money']) {
			$error = 1;
		}
		
		if ($skillObj->row['cumulative']){
			$skill_userObj = new Skill_user;
		}
		else {
			$skill_userObj = new Skill_user(array(
				'skill_id'=>$skill_id,
				'user_id'=>$_SESSION['user']['user_id']
				));
			
			if ($skill_userObj->row){
				$error = 2;
			}
		}
		
		if (!$error){

			$skill_userObj = new Skill_user;
			$skill_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$skill_userObj->set['skill_id'] = $skill_id;
			$skill_userObj->set['ability'] = 'Noob';
			$skill_userObj->save();
			
			//echo mysql_error();
			
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['money'] = $userObj->row['money'] - $skillObj->row['value'];
			$userObj->save();
			
			$this->vars('cost',$skillObj->row['value']);
			$this->vars('money',$userObj->set['money']);
		}
		
		$this->vars('error',$error);


	}
	
	function table(){
	
		$skillObj = new Skill('all');
		
		$abilitys = $skillObj->get_abilitys();
		
		foreach ($skillObj->data as $skill) {
			
			echo "<p>".$skill['name']."<p>";
			
			echo "<table border='1'>";
			
			echo "<tr><td>Version</td><td>Cost</td><td>Damage</td><td>Cooldown</td><td>Exp</td>";
			
			$level = 1;
			
			foreach ($abilitys as $k => $ability) {
		
				$damage = $skillObj->calc_damage($k, $skill['damage'], $skill['level']);
				
				
				$hits =  $skill['damage']?floor($k / (($damage['min'] + $damage['max']) / 2)):'infinity';
				
				echo "<tr>";
				echo "<td>".$ability."</td>";
				echo "<td>".$skill['value']."</td>";	
				echo "<td>".$damage['min']."-".$damage['max']."</td>";
				echo "<td>".$skillObj->calc_cooldown($k, $skill['damage'], $skill['level'])."</td>";
				echo "<td>".$k."<span style='font-size: 10px;'>(approx ".$hits." hits without powerups)</span></td>";
				echo "</tr>";
				$level = $level+'0';
			}
		
			echo "</table>";
		}
	}	
	
}
?>