<?php

class softwareController extends Controller {

	function ajax_softwareBuyProcess($software_id){
	
		$error = 0;
		
		$softwareObj = new Software($software_id);
		$userObj = new User($_SESSION['user']['user_id']);

		if ($softwareObj->row['value'] > $userObj->row['money']) {
			$error = 1;
		}
		else {
			$software_userObj = new Software_user(array(
				'software_id'=>$software_id,
				'user_id'=>$_SESSION['user']['user_id']
				));
			
			if ($software_userObj->row){
				$error = 2;
			}		
		}

		if (!$error){

			$software_userObj = new Software_user;
			$software_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$software_userObj->set['software_id'] = $software_id;
			$software_userObj->set['level'] = '1';
			$software_userObj->set['version'] = '1';
			$software_userObj->save();
			
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['money'] = $userObj->row['money'] - $softwareObj->row['value'];
			$userObj->save();
			
			$this->vars('cost',$softwareObj->row['value']);
			$this->vars('money',$userObj->set['money']);
		}
		
		$this->vars('error',$error);
		
	}
	
	function ajax_softwareUpgradeProcess($software_id){
	
		$error = 0;
	
		$softwareObj = new Software($software_id);
		$userObj = new User($_SESSION['user']['user_id']);

		$software_userObj = new Software_user(array(
			'software_id'=>$software_id,
			'user_id'=>$_SESSION['user']['user_id'])
			);
		
		if (!$software_userObj->row){
			$error = 3;
		}
		else {
			$value = $softwareObj->calc_value(
				$softwareObj->row['damage'],
				$softwareObj->row['level'],
				$software_userObj->row['version']
				);
		}
		
		if ($value > $userObj->row['money']) {
			$error = 1;
		}		

		if (!$error) {
		
			$software_userObj = new Software_user(array(
				'user_id'=>$_SESSION['user']['user_id'], 
				'software_id'=>$software_id
				));
				
			$software_userObj->set['software_user_id'] = $software_userObj->row['software_user_id'];
			$software_userObj->set['version'] = $software_userObj->row['version']+1;
			$software_userObj->save();
			
			$userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$userObj->set['money'] = $userObj->row['money'] - $value;
			$userObj->save();
			
			$this->vars('cost',$value);
			$this->vars('money',$userObj->set['money']);
		}
		
		
		$this->vars('error',$error);
	}	
	
	function table(){
	
		$softwareObj = new Software('all');
		
		foreach ($softwareObj->data as $software) {
			
			echo "<p>".$software['name']."<p>";
			
			echo "<table border='1'>";
			
			echo "<tr><td>Version</td><td>Cost</td><td>Damage</td>";
			
			$version = 1;
			
			while ($version <= 40){
		
				$damage = $softwareObj->calc_damage($software['level'],$software['damage'],$version);
		
				echo "<tr>";
				echo "<td>".$version."</td>";
				echo "<td>".$softwareObj->calc_value($software['level'],$software['damage'],$version)."</td>";	
				echo "<td>".$damage['min']."-".$damage['max']."</td>";
				echo "<td>".$softwareObj->calc_cooldown($software['cooldown'],$software['level'],$version)."</td>";
				echo "</tr>";
				$version++;
			}
		
			echo "</table>";
		}
	}
}

?>