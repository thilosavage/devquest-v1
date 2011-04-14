<?php
class adminController extends Admin{

	var $unprotected_actions = array('index');
	
	function index(){
		$error = isset($_POST['submit'])?$this->_process():false;
		$this->vars('error',$error);
		$this->vars('formData',$formData);
		if (isset($_SESSION['admin']))$this->redirect('admin/manager');
	}	
	
	function manager() {
	}
	
	function utility(){
	
	}
	function map(){


		if ($_POST['loc']) {
		

			$loc = new Loc;

			$loc->set = $_POST['loc'];
			
			//if ($_POST['loc_id']){
			//	 $loc->set['loc_id'] = $_POST['loc_id'];
			//}
			//else {
			//	$loc->set['x'] = $_POST['x'];
			//	$loc->set['y'] = $_POST['y'];		
			//}
			
			//$loc->set['name'] = $_POST['name'];
			//$loc->set['type'] = $_POST['type'];
			
			if ($loc->set['name']) {
			
				$loc_id = $loc->save();
				
				$loc->set['loc_id'] = $loc_id;
				
				$success = true;
			}
			else {

				if ($loc->set['loc_id']) {

					$loc->delete($loc->set['loc_id']);

				}
				$success = false;				
				
			}
						
			$this->vars('success',$success);
			$this->vars('data',$loc->set);
			
			echo mysql_error();		
		}
	
		$locs = new Loc('all');
		
		foreach ($locs->data as $loc){
		
			$coordsX = $loc['x'];
			$coordsY = $loc['y'];
			$xs[$coordsX][$coordsY] = $loc;
			
		}
		
		$this->vars('xs',$xs);
	
	}
	
	function ajax_locEditOpen(){
		$locObj = new Loc($_POST['loc_id']);
		$this->vars('loc',$locObj->row);
	}
	function ajax_locEditProcess(){
		

	
	}
	
	function ajax_locDeleteProcess(){
		$loc = new Loc($_POST['loc_id']);
		$loc->delete($_POST['loc_id']);
		
		$data['x'] = $loc->row['x'];
		$data['y'] = $loc->row['y'];
		
		$this->vars('data',$data);
		
	}
	
	function bug_manager(){
		
		$bugObj = new Bug;

		if ($_POST['change']) {
			
			foreach ($_POST as $k => $post){
				if (is_numeric($k)){
					if ($post['bugname']) {
						$bugObj->clear();
						$bugObj->set = $post;
						$bugObj->save();				
					}
					else {
						$bugObj->delete($post['bug_id']);
					}
				}
				else if ($k=='new' && $post['bugname']){
				
					unset($post['bug_id']);
				
					$bugObj->clear();
					$bugObj->set = $post;
					$bugObj->save();			
				
				}
			}
		}
		
		$bugObj->clear();
		$bugObj->sort_order = 'level ASC'; 
		$bugObj->load(array('bug_id>'=>'0'));

		$bugs = $bugObj->data;
		$this->vars('bugs',$bugs);
		
	}
	
	
	
	function item_manager(){
		
		$itemObj = new Item;

		if ($_POST['change']) {
			
			
			foreach ($_POST as $k => $post){
				if (is_numeric($k)){
					if ($post['name']) {
						$itemObj->clear();
						$itemObj->set = $post;
						$itemObj->save();				
					}
					else {
						$itemObj->delete($post['item_id']);
					}
				}
				else if ($k=='new' && $post['name']){
				
					unset($post['item_id']);
				
					$itemObj->clear();
					$itemObj->set = $post;
					$itemObj->save();			
				
				}
			}
		}
		
		$itemObj->clear();
		$itemObj->sort_order = 'level ASC'; 
		$itemObj->load(array('item_id>'=>'0'));

		$items = $itemObj->data;
		$this->vars('items',$items);
		
	}
	
	
	function gig_manager($loc_id) {
	
		$gigObj = new Gig;
		$locObj = new Loc;
		$skillObj = new Skill;
		$softwareObj = new Software;
		$gig_softwareObj = new Gig_software;
		$gig_skillObj = new Gig_skill;	
		$stattribs = settings::$stattribs;
		
		if ($_POST['change']) {

			$gig_skillObj->custom('DELETE FROM `gig_skill` WHERE `gig_id` = %s', $_GET['gig_id']);
			$gig_skillObj->clear();
			
			$gig_softwareObj->custom('DELETE FROM `gig_software` WHERE `gig_id` = %s', $_GET['gig_id']);
			$gig_softwareObj->clear();
			
			$skillObj->clear();
			
			if ($_POST['gig']['level'] == '0') {
			
				$gigObj->custom('DELETE FROM `gig` WHERE `gig_id` = %s', $_GET['gig_id']);
				$this->redirect('admin/gig_manager/'.$this->id);
			
			}
			else {

				foreach ($_POST['skill'] as $skill_id => $exp_req) {
				
					if ($exp_req) {
				
						$gig_skillObj->set['gig_id'] = $_GET['gig_id'];
						$gig_skillObj->set['skill_id'] = $skill_id;
						$gig_skillObj->set['exp_req'] = $exp_req;
						$gig_skillObj->save();
						
						$gig_skillObj->clear();
					}
					
				}
				$gig_skillObj->clear();
				
				foreach ($_POST['software'] as $software_id => $version) {
				
					if ($version) {
				
						$gig_softwareObj->set['gig_id'] = $_GET['gig_id'];
						$gig_softwareObj->set['software_id'] = $software_id;
						$gig_softwareObj->set['version_req'] = $version;
						$gig_softwareObj->save();
						
						$gig_softwareObj->clear();
					}
					
				}
				$gig_skillObj->clear();			

				$gigObj->set = $_POST['gig'];
			
				foreach ($stattribs as $stat) {
					$gigObj->set[$stat] = $_POST['stat'][$stat];
				}
				
				$gigObj->set['gig_id'] = $_GET['gig_id'];
				$gigObj->save();

				$gigObj->clear();
				
			}

		
		}

		if ($_POST['new']) {
		
			$gigObj->set = $_POST['gig'];
			$gigObj->set['loc_id'] = $this->id;
			$gig_id = $gigObj->save();
			
			$this->redirect('admin/gig_manager/'.$this->id.'?gig_id='.$gig_id);
		
		}
		
		if ($_GET['gig_id']) {


			$gigObj->load($_GET['gig_id']);
			
			echo "<p>".$gigObj->row['desc']."</p>";
	
			$gigObj->load(array('gig_id>'=>'0'));
			

			echo form::start(site::url.'admin/gig_manager/'.$loc_id.'?gig_id='.$_GET['gig_id']);
			
			$skillObj->load(array('skill_id>'=>'0'));
			$skills = $skillObj->get_abilitys();
			$revskills = array_flip($skills);
			foreach ($skillObj->data as $skill) {
			
				$gig_skillObj->load(array(
					'gig_id'=>$_GET['gig_id'],
					'skill_id'=>$skill['skill_id']
					));
				
				$expreq = $revskills[$gig_skillObj->row['exp_req']];
			
				$sl = form::select("skill[".$skill['skill_id']."]",$expreq,$skills,true);
				echo $sl.$skill['name']." <br>";
				$gig_skillObj->clear();
			}
			
			echo "<br><br>";
			
			
			$softwareObj->load(array('software_id>'=>'0'));
			foreach ($softwareObj->data as $software) {
			
				$gig_softwareObj->load(array(
					'gig_id'=>$_GET['gig_id'],
					'software_id'=>$software['software_id']
					));			
			
				$sl = form::input("software[".$software['software_id']."]",$gig_softwareObj->row['version_req'],"size=5");
				echo $sl.$software['name']." <br>";
				$gig_softwareObj->clear();
			}
			
			echo "<br><br>";
			
			foreach ($stattribs as $stat) {
			
				$sl = form::input("stat[".$stat."]",$gigObj->row[$stat],"size=10");
				echo $sl.$stat." <br>";
			
			}
			
			echo form::submit('change','change');
			
			echo "<br><br>";
			
			echo "Level: ".form::input('gig[level]',$gigObj->row['level']);
			echo "Desc: ".form::text('gig[desc]',$gigObj->row['desc']);
			echo "Response: ".form::text('gig[response]',$gigObj->row['response']);			
			
			
			echo "</form>";
			echo "<a href='".site::url."admin/gig_manager/".$loc_id."'>Back</a>";
		
		}
		
		else if ($loc_id) {
			echo "<a href='".site::url."admin/gig_manager'>Back</a><br><br>";
			
			$gigObj->load(array('loc_id'=>$loc_id));
			
			foreach ($gigObj->data as $gig) {
			
				echo "<a href='".site::url."admin/gig_manager/".$loc_id."?gig_id=".$gig['gig_id']."'>".$gig['level']." - ".$gig['desc']."</a><br>";
			
				$gig_skillObj->load(array('gig_id'=>$gig['gig_id']));
			
			}

			echo form::start(site::url.'admin/gig_manager/'.$this->id);
			echo "Level: ".form::input('gig[level]');
			echo "<br>";
			echo "Desc: ".form::text('gig[desc]');
			echo "Response: ".form::text('gig[response]');
			
			echo form::submit('new','new');
			echo "</form>";		
			
			
			echo "<br><a href='".site::url."admin/gig_manager'>Back</a><br>";
		
		}		
		
		
		
		else {
			
			$locObj->load(array('has_gig'=>'1'));

			
			foreach ($locObj->data as $loc) {
			
				echo "<a href='".site::url."admin/gig_manager/".$loc['loc_id']."'>".$loc['name']." (#".$loc['loc_id'].")</a><br>";
			}
		
		}
		
		
	}
	
	function job_manager($loc_id) {
	
		$jobObj = new Job(array('loc_id'=>$loc_id));
		$locObj = new Loc;
		$skillObj = new Skill;
		$softwareObj = new Software;
		$job_softwareObj = new Job_software;
		$job_skillObj = new Job_skill;	
		$stattribs = settings::$stattribs;
		
		$job_id = $jobObj->row['job_id'];
		
		if ($_POST['change']) {
			
			if ($job_id) {
			
				$job_skillObj->custom('DELETE FROM `job_skill` WHERE `job_id` = %s', $job_id);
				$job_skillObj->clear();
				
				$job_softwareObj->custom('DELETE FROM `job_software` WHERE `job_id` = %s', $job_id);
				$job_softwareObj->clear();
				
				$skillObj->clear();
				
				if ($_POST['job']['level'] == '0') {
				
					$jobObj->custom('DELETE FROM `job` WHERE `job_id` = %s', $job_id);
					$this->redirect('admin/job_manager/'.$this->id);
				
				}
			}

			$job_skillObj->clear();

			$jobObj->set = $_POST['job'];
			$jobObj->set['loc_id'] = $loc_id;
			
			foreach ($stattribs as $stat) {
				$jobObj->set[$stat] = $_POST['stat'][$stat];
			}
			if ($job_id) {
				$jobObj->set['job_id'] = $job_id;
			}
			
			$job_id = $jobObj->save();	
			
			foreach ($_POST['skill'] as $skill_id => $exp_req) {
				
				if ($exp_req) {
			
					$job_skillObj->set['job_id'] = $job_id;
					$job_skillObj->set['skill_id'] = $skill_id;
					$job_skillObj->set['exp_req'] = $exp_req;
					$job_skillObj->save();
					
					$job_skillObj->clear();
				}
				
			}
			$job_skillObj->clear();
			
			foreach ($_POST['software'] as $software_id => $version) {
			
				if ($version) {
			
					$job_softwareObj->set['job_id'] = $job_id;
					$job_softwareObj->set['software_id'] = $software_id;
					$job_softwareObj->set['version_req'] = $version;
					$job_softwareObj->save();
					
					$job_softwareObj->clear();
				}
				
			}

			$jobObj->clear();

		}

		if ($loc_id) {

			$jobObj->load(array('loc_id'=>$loc_id));
			
			echo "<p>".$jobObj->row['name']."</p>";
	
			$jobObj->load(array('job_id>'=>'0'));
			
			echo form::start(site::url.'admin/job_manager/'.$loc_id);
			
			$skillObj->load(array('skill_id>'=>'0'));
			$skills = $skillObj->get_abilitys();
			$revskills = array_flip($skills);
			foreach ($skillObj->data as $skill) {
			
				$job_skillObj->load(array(
					'job_id'=>$job_id,
					'skill_id'=>$skill['skill_id']
					));
					
				$expreq = $revskills[$job_skillObj->row['exp_req']];
				
				$sl = form::select("skill[".$skill['skill_id']."]",$expreq,$skills,true);
				echo $sl.$skill['name']." <br>";
				$job_skillObj->clear();
			}
			
			echo "<br><br>";
			
			
			$softwareObj->load(array('software_id>'=>'0'));
			foreach ($softwareObj->data as $software) {
			
				$job_softwareObj->load(array(
					'job_id'=>$job_id,
					'software_id'=>$software['software_id']
					));			
			
				$sl = form::input("software[".$software['software_id']."]",$job_softwareObj->row['version_req'],"size=5");
				echo $sl.$software['name']." <br>";
				$job_softwareObj->clear();
			}
			
			echo "<br><br>";
			
			foreach ($stattribs as $stat) {
			
				$sl = form::input("stat[".$stat."]",$jobObj->row[$stat],"size=10");
				echo $sl.$stat." <br>";
			
			}
			
			echo form::submit('change','change');
			
			echo "<br><br>";
			
			
			echo "Name: ".form::input('job[name]',$jobObj->row['name']);
			
			echo "Level: ".form::input('job[level]',$jobObj->row['level']);
			echo "Processor: ".form::input('job[processor]',$jobObj->row['processor']);
			echo "Time: ".form::input('job[time]',$jobObj->row['time']);		
			echo "<br>";
			
			echo "Desc: ".form::text('job[desc]',$jobObj->row['desc']);
			echo "Response: ".form::text('job[response]',$jobObj->row['response']);			
			echo "Fired: ".form::text('job[fired]',$jobObj->row['fired']);		
			
			
			
			echo "</form>";
			echo "<a href='".site::url."admin/job_manager'>Back</a>";
		
		}
		
		else {
			
			$locObj->load(array('has_job'=>'1'));

			
			foreach ($locObj->data as $loc) {
			
				echo "<a href='".site::url."admin/job_manager/".$loc['loc_id']."'>".$loc['name']." (#".$loc['loc_id'].")</a><br>";
			}
		
		}
	}
	
}
?>