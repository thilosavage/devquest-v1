<?php
class inc{
	var $data = array();

	public static function lude($path){
		require(site::root.$path);
		return ob_get_flush(); 
	}
	
	public function module($module,$data=array()){
		ob_start();
		include(site::root.'_modules/'.$module.'.php');
		$bah = ob_get_contents();
		ob_end_clean();
		return $bah;
	}
	
	public function quest($quest,$data=array()){
		ob_start();
		include(site::root.'_quests/'.$quest.'.php');
		$bah = ob_get_contents();
		ob_end_clean();
		return $bah;
	}	

	public static function form($form,$data=array()){

		ob_start();
		include(site::root.'_forms/'.$form.'.php');
		$bah = ob_get_contents();
		ob_end_clean();
		return $bah;

	}

	function hook($file){
		if (file_exists($file.".php")){
			include($file.".php");
			return false;
		}
		else {
			return true;
		}
	}
	
	public static function js($file='compiler.js',$path='_javascript/',$passPath=true){
		$ret = "<script type='text/javascript' src='".site::url.$path.$file;
		$ret .= "' type='text/javascript'></script>";
		echo $ret;
	}
	public static function css($file='styles.css',$path='_styles/',$passPath=true){
		$ret = "<link href='".site::url.$path.$file;
		$ret .= "' rel='stylesheet' type='text/css' />";
		echo $ret;
	}
}
?>