<?php

class showController extends Controller {

	function ajax_showJoinOpen(){
	
		$time = time();
		$shows = new Show(array('start <'=>$time, 'end >'=>$time));
		$this->vars('shows',$shows->data);
		
	}
	
	function ajax_showPromoteProcess() {
	
		$time = time();
		$shows = new Show(array('start <'=>$time, 'end >'=>$time));
		$this->vars('shows',$shows->data);	

	}
	
	function ajax_showMyLoad(){
	
		$shows = new Show(array('creator_id'=>$_SESSION['user']['user_id']));
		$this->vars('shows',$shows->data);
	
	}
	
	function ajax_showNewForm(){
		
		$durations = array(
			'300' => 'Five minutes',
			'600' => 'Ten minutes',
			'900' => 'Fifteen minutes',
			'3600' => 'One hour'
		);
		
		$this->vars('durations',$durations);
		
	}
	
	function ajax_showNewProcess(){
		
		$showName = $_POST['showName'];
		$time = time();
		$duration = $_POST['duration'];
		
		$show = new Show;
		$show->set['creator_id'] = $_SESSION['user']['user_id'];
		$show->set['name'] = $showName;
		$show->set['start'] = $time;
		$show->set['end'] = $time + $duration;
		
		if ($show->save()){
			$history = new History;
			$message = historys::show($showName);
			$history->entry($message,$time);
		}
		
		$this->vars('time',$time);
		$this->vars('historys',$history->set);
		$this->vars('showData',$show->set);		
		
	}
	
	function ajax_showMyPromote(){
	
	
		
	}	
	
	function ajax_showInfoLoad($show_id){
	
		$show = new Show(array('show_id'=>$show_id));
		
		$this->vars('show',$show->row);
	
	}
	
	function ajax_showJoinProcess(){

		$show_id = $_POST['show_id'];
		
		$show_users = new Show_user;
		
		$show_users->set['user_id'] = $_SESSION['user']['user_id'];
		$show_users->set['show_id'] = $show_id;
		$show_users->set['join'] = time();
		$_SESSION['show_user_id'] = $show_users->save();	

		$show_users->clear();
		
		$show_users->load(array('show_id'=>$show_id));
		$attendees = $show_users->data;
		
		$this->session('attendees',$attendees);
	
	}
	
	function ajax_showLeaveProcess(){
		
		$time = time();
		
		$show_users = new Show_user(array('show_user_id'=>$_SESSION['show_user_id']));
		$show_users->set['show_user_id'] = $_SESSION['show_user_id'];
		$show_users->set['leave'] = $time;
		$show_users->save();
		unset($_SESSION['show_user_id']);
		
		$totalTime = $time - $show_users->row['join'];
	
	
		$entry = "You attended the show BLAH for ".$totalTime." seconds";
		$history = new History;
		$history->set['user_id'] = $_SESSION['user']['user_id'];
		$history->set['entry'] = $entry;
		$history->set['time'] = $time;
		$history->save();

		$historyData['entry'] = $entry;
		$historyData['time'] = $time;
		
		$this->vars('time',$time);
		$this->vars('historys',$historyData);	
	
	}
}
?>