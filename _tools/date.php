<?php
class date {
	
	// converts unix timestamp to January 4th, 2007
	function unixToFancy($str){
		return self::fancy(date("Ymd g:ia T", $str));
	}
	
	// converts yyymmdd to dd/mm/yyyy
	function slashes($str){
	
		$year = substr($str, 2, 2);
		$month = substr($str, 4, 2);
		$day = substr($str, 6, 2);
		
		return $day."/".$month."/".$year;
	
	}
	
	function history($date){
	
	}
	
	// converts yyyy/mm/dd to January 4th, 2007
	function fancy($d) {
	
		$year = substr($d, 0, 4);
		$month = substr($d, 4, 2);
		$day = substr($d, 6, 2);
		
		$time = " ".substr($d,8);
		
		switch ($month) {
			case "01": $month = "January"; break;
			case "02": $month = "February"; break;
			case "03": $month = "March"; break;
			case "04": $month = "April"; break;
			case "05": $month = "May"; break;		
			case "06": $month = "June"; break;		
			case "07": $month = "July"; break;
			case "08": $month = "August"; break;
			case "09": $month = "September"; break;
			case "10": $month = "October"; break;
			case "11": $month = "November"; break;	
			case "12": $month = "December"; break;
		}

		
		$st = array('01', '21', '31');
		$nd = array('02', '22');
		$rd = array('03', '23');
		
		if (in_array($day, $st)) {
			$day = $day."st";
		}
		else if (in_array($day, $nd)) {
			$day = $day."nd";
		}
		else if (in_array($day, $rd)) {
			$day = $day."rd";
		}
		else {
			$day = $day."th";
		}
		$unzero = substr($day, 0, 1);
		if ($unzero == "0") {
			$day = substr($day, 1);
		}
		
		return $month." ".$day.", ".$year.$time;
		
	}
	
	function daysAgo($days){
		return date('Ymd',mktime(0, 0, 0, date("m")  , date("d")-$days, date("Y")));
	}
	
	function activeTest($date){
	
		$thisDate = site::debug?date('Ymd',mktime(0, 0, 0, date("m")  , date("d")+3, date("Y"))):date('Ymd');
		
		if ( (date('G') > settings::$timeToAirVideos && $date == $thisDate)     ||    $date < $thisDate   ){
			return true;
		}
		else {
			return false;
		}
	}
}
?>