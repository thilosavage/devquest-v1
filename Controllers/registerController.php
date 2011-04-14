<?php
class registerController extends Controller {
	
	function prep(){
		if ($_SESSION['user']){
			$this->redirect('world');
		}	
	}
	
	function index(){
	}
	
	function process(){

		$user = new User;
		if ($user->verifyNewUser($_POST['name'])){
		
			$user->process($_POST['name'],$_POST['password']);
			$user->login($_POST['name'],$_POST['password']);
			
			$this->redirect('world');
		}
		else {
			$this->redirect('register');
		}
	}
}
?>