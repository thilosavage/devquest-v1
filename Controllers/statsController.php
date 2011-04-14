<?php

class statsController extends Controller {

	function ajax_statsUtilityOpen(){
		
		$userObj = new User($_SESSION['user']['user_id']);
		
		$item_userObj = new Item_user(array(
			'user_id'=>$_SESSION['user']['user_id'],
			'equipped'=>'1'
			));
		
		$attribs = settings::$attribs;
		
		foreach ($item_userObj->data as $item){
			foreach ($attribs as $attrib){

				$userObj->row[$attrib] = $userObj->row[$attrib] + $item[$attrib];
			}
		}
	
		$_SESSION['user'] = $userObj->row;
	
		$skill_userObj = new Skill_user(array(
			'user_id'=>$_SESSION['user']['user_id']
			));
		
		foreach ($skill_userObj->data as $skillData) {
			$skill_ids[] = $skillData['skill_id'];
		}
		
		$skillObj = new Skill($skill_ids);
		
		foreach ($skill_userObj->data as $skillData) {
		
			$skill_id = $skillData['skill_id'];
		
			$skills[] = array(
				'name'=>$skillObj->data[$skill_id]['name'],
				'ability'=>$skillData['ability'],
				'skill_id'=>$skill_id
				);
		}		
		
		$software_userObj = new Software_user(array(
			'user_id'=>$_SESSION['user']['user_id']
			));
			
		foreach ($software_userObj->data as $softwareData) {
			$software_ids[] = $softwareData['software_id'];
		}
		
		
		$softwareObj = new Software($software_ids);
		
		foreach ($software_userObj->data as $softwareData) {
		
			$software_id = $softwareData['software_id'];

			$softwares[] = array(
				'name'=>$softwareObj->data[$software_id]['name'],
				'version'=>$softwareData['version'],
				'software_id'=>$softwareData['software_id']
				);
				
		}
		
		$this->vars('user',$userObj->row);
		$this->vars('skills',$skills);
		$this->vars('softwares',$softwares);
	}

}

?>