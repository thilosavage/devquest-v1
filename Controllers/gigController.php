<?php

class gigController extends Controller {

	function ajax_gigApplyProcess(){

		if ($error) {
			$response = $gigRow['error'];
		}
		else {

			$gig = new Gig;
			$gig->use_id_values = false;
			$gig->load(array('loc_id'=>$_SESSION['user']['loc_id']));
			
			$user = new User($_SESSION['user']['user_id']);
			$gig_userObj = new Gig_user(array(
				'`user_id`'=>$_SESSION['user']['user_id']
				));
			
			$gigsCompleted = count($gig_userObj->data);
			$gigRow = $gig->data[$gigsCompleted];
			
			$nextGigID = $gigsCompleted + 1;
			
			$nextGig = $gig->data[$nextGigID];
		
			$gig_userObj->set['user_id'] = $_SESSION['user']['user_id'];
			$gig_userObj->set['loc_id'] = $_SESSION['user']['loc_id'];
			$gig_userObj->set['gig_id'] = $gigRow['gig_id'];
			$gig_userObj->set['day'] = time();
			$gig_userObj->save();
			
			$response = $gigRow['response'];
		}
		
		$this->vars('nextGig',$nextGig);
		$this->vars('response',$response);
	
	}

}

?>