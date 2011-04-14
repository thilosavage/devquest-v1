<?php 
class Gig extends Model {

	protected $table = 'gig';
	protected $id_field = 'gig_id';
	protected $name_field = 'gig_id';
	protected $order_by = 'level ASC';

	
	function get_gig($gig){
	
		$ret['qualified'] = true;

		$skillObj = new Skill;
		
		$skill_userObj = new Skill_user;
		$skill_userObj->custom_id = 'skill_id';
		$skill_userObj->load(array('user_id'=>$_SESSION['user']['user_id']));		
		
		$gig_skillObj = new Gig_skill;
		$gig_skillObj->custom_id = 'skill_id';
		$gig_skillObj->load(array('gig_id'=>$gig['gig_id']));	
		
		foreach ($gig_skillObj->data as $skill_id => $gig_skill) {
			
			$skillObj->load($skill_id);
			
			$currentSkillExp = $skill_userObj->data[$skill_id]['exp'];
			$reqSkillExp = $skillObj->abilityToNumber($gig_skill['exp_req']);
			
			$skill_current_render = $skillObj->get_ability($currentSkillExp);
			$skill_current = $skill_current_render?$skill_current_render['name']:'None';
			
			$ret['requirements']['skills'][$skillObj->row['name']]['need'] = $gig_skill['exp_req'];
			$ret['requirements']['skills'][$skillObj->row['name']]['current'] = $skill_current;
			
			
			
			if ($reqSkillExp > $currentSkillExp) {
				$ret['requirements']['skills'][$skillObj->row['name']]['fail'] = $reqSkillExp."--".$currentSkillExp;
				$ret['qualified'] = false;
				
			}
			$skillObj->clear();
			
		}
		
		
		$softwareObj = new Software;
		
		$software_userObj = new Software_user;
		$software_userObj->custom_id = 'software_id';
		$software_userObj->load(array('user_id'=>$_SESSION['user']['user_id']));
		
		$gig_softwareObj = new Gig_software;
		$gig_softwareObj->custom_id = 'software_id';
		$gig_softwareObj->load(array('gig_id'=>$gig['gig_id']));				
		
		foreach ($gig_softwareObj->data as $software_id => $software) {
			
			$softwareObj->load($software_id);

			$ret['requirements']['software'][$softwareObj->row['name']]['need'] = $software['version_req'];
			$ret['requirements']['software'][$softwareObj->row['name']]['current'] = $software_userObj->data[$software_id]['version'];
			
			
			if ($software['version_req'] > $software_userObj->data[$software_id]['version']) {
				$ret['requirements']['software'][$softwareObj->row['name']]['fail'] = true;
				$ret['qualified'] = false;
			}
		}		
		
		
		$stattribs = settings::$stattribs;
		
		foreach ($stattribs as $attrib) {
			if ($gig[$attrib]) {
				$ret['requirements']['stats'][$attrib]['need'] = $gig[$attrib];
				$ret['requirements']['stats'][$attrib]['current'] = $_SESSION['user'][$attrib];
				
				if ($_SESSION['user'][$attrib] < $gig[$attrib]) {
					$ret['requirements']['stats'][$attrib]['fail'] = true;
					$ret['qualified'] = false;
				}
			}			
		}
		
		$ret['offers']['stat']['processor'] = $gig['processor'];		

		
		return $ret;
		
	}
	
	
}
?>