<?php

class jobController extends Controller {

	function ajax_jobApplyProcess(){
	
		$job_userObj = new Job_user;
		$userObj = new User($_SESSION['user']['user_id']);
		$jobObj = new Job(array('loc_id'=>$_SESSION['user']['loc_id']));
		
		$job_userObj->set['user_id'] = $userObj->row['user_id'];
		$job_userObj->set['job_id'] = $jobObj->row['job_id'];
		$job_userObj->set['time'] = time();
		$job_userObj->save();
		
		$response = $jobObj->row['response'];
		
		$this->vars('response',$response);
	
	}
	
	function ajax_jobWorkStart(){
	
	
	
	
	}


}

?>