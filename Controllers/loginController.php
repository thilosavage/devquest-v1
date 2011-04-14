<?php
class loginController extends Controller {
	function prep(){
		if ($_SESSION['user']){
			//$this->redirect('world');
		}
	}
	function ajax_process($action){

		$user = new User;

		//if ($user->login($_POST['name'],$_POST['password'])){
			//$this->redirect('world');
		//}
		

		if ($cookie){	
			
			if ($action == 'redirect'){
				echo "redirect";
			}
		}
		else {
			$_SESSION['message'] = "Login failed";
			echo "Failed to login";
		}
		
	}
}
?>