<?php

class mapController extends Controller {

	function ajax_mapUtilityOpen(){
	
		$locObj = new Loc;

		$xm = $locObj->generateMap($_SESSION['user']['level']);
		
		$this->vars('coords',$xm);

	
	}


}

?>