<?php

class historys {

	function display($historys){

		$ret = '';
		foreach ($historys as $history){
			$ret .= "<div class='history-entry'>";
				$ret .= "<span class='history-date'>".date::history($history['time'])."</span>";
				$ret .= "<span class='history-text'>".$history['entry']."</span>";
				$ret .= "<span style='float: right;' class='fakelink historyEntryHide'>Hide</span>";
			$ret .= "</div>";
		}
	
		return $ret;
	}
	
	public static function show($showName){
		return "You set up a show called ".$showName;
	}
	
	public static function act($bandName){
		return "You created a new band called the ".$bandName;	
	}
	
}

?>