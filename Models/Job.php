<?php 
class Job extends Model {

	protected $table = 'job';
	protected $id_field = 'job_id';
	protected $name_field = 'job_id';
	protected $order_by = 'level ASC';
	
	function get_job($job){

		$ret = $job;
		
		$ret['qualified'] = true;
		$skillObj = new Skill;
		
		$skill_userObj = new Skill_user;
		$skill_userObj->custom_id = 'skill_id';
		$skill_userObj->load(array('user_id'=>$_SESSION['user']['user_id']));
		
		$job_skillObj = new Job_skill;
		$job_skillObj->custom_id = 'skill_id';
		$job_skillObj->load(array('job_id'=>$this->row['job_id']));	
		
		foreach ($job_skillObj->data as $skill_id => $job_skill) {
			
			$skillObj->load($skill_id);
			
			$currentSkillExp = $skill_userObj->data[$skill_id]['exp'];
			$reqSkillExp = $skillObj->abilityToNumber($job_skill['exp_req']);
			
			$skill_current_render = $skillObj->get_ability($currentSkillExp);
			$skill_current = $skill_current_render?$skill_current_render['name']:'None';
			
			$ret['requirements']['skills'][$skillObj->row['name']]['need'] = $job_skill['exp_req'];
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
		
		$job_softwareObj = new Job_software;
		$job_softwareObj->custom_id = 'software_id';
		$job_softwareObj->load(array('job_id'=>$this->row['job_id']));				
		
		foreach ($job_softwareObj->data as $software_id => $software) {
			
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
			if ($job[$attrib]) {
				$ret['requirements']['stats'][$attrib]['need'] = $job[$attrib];
				$ret['requirements']['stats'][$attrib]['current'] = $_SESSION['user'][$attrib];
				
				if ($_SESSION['user'][$attrib] < $job[$attrib]) {
					$ret['requirements']['stats'][$attrib]['fail'] = true;
					$ret['qualified'] = false;
				}
			}			
		}
		
		$ret['offers']['stat']['processor'] = $this->row['processor'];
		
		return $ret;
	}
	
	function render_job($job_user) {
	
		$data['exp_increase'] = 10;
	
		return $data;
	
	}
}
?>