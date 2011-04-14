<?php
class indexController extends Controller {

	function prep(){
		if ($_SESSION['user']){
			//$this->redirect('world');
		}
	}

	function index(){
		

		$fbvars['appId'] = site::fbapp_id;
		$fbvars['secret'] = site::fbapp_secret;
		$fbvars['cookie'] = true;
		//$fbvars[] = 'http://localhost/zynga/';
   
		$facebook = new Facebook($fbvars);
		$fbSession = $facebook->getSession();
	
		if ($fbSession && $_SESSION['user']['user_id']){
			$this->redirect('world');
		}
		
	}

	function calculate(){

		$this->layout='_blank';

		$users = new User('all');
		$items = new Item;
		$artists = new Artist;

		if ($users->data){
			foreach ($users->data as $user){

				$items->load(array('user_id'=>$user['user_id']));
				if ($items->data){ 
					foreach ($items->data as $item){

						$artists->load(array('artist_id'=>$item['artist_id']));
						$status = $status + $item['value'] * $artists->row['influence'] / $artists->row['pop'];

					}
				}

				$status = round($status);
				
				$users->$this->vars['status'] = $status;
				$users->$this->vars['user_id'] = $_SESSION['user']['user_id'];

				$users->save();	

				$users->clear();
				$artists->clear();
				$items->clear();
			}		
		}
	}	
}
?>