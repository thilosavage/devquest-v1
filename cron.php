<?php
if ($_SERVER['DOCUMENT_ROOT'] !== 'D:/xampp/htdocs'){
	$dbhost = 'localhost';
	$dbuser = 'jumping4_maven';
	$dbpass = 'maven123';
	$dbname = 'jumping4_maven';
}
else {
	$dbhost = 'localhost';
	$dbuser = 'game';
	$dbpass = 'game123';
	$dbname = 'game';
}


$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$uQ = mysql_query("SELECT * FROM `user`");
while ($user = mysql_fetch_array($uQ)){

	$iQ = mysql_query("SELECT * FROM `item` WHERE `user_id` = '".$user['user_id']."'");
	while ($item = mysql_fetch_array($iQ)){
	
		$aQ = mysql_query("SELECT * FROM `artist` WHERE `artist_id` = '".$item['artist_id']."'");
		while ($artist = mysql_fetch_array($aQ)){
		
			$status = $status + ($item['value'] * $artist['influence'] / $artist['pop']);

		}
	
	}
	
	$status = round($status);
	$money = $user['money'] + 1;
	
	$update = "UPDATE `user` SET `status` = ".$status.", `money` = ".$money." WHERE `user_id` = '".$user['user_id']."'";
	mysql_query($update);
	
	$time = time();
	if (($user['lastEvent'] + 10) < $time){
		$update = "UPDATE `user` SET `online` = '0' WHERE `user_id` = '".$user['user_id']."'";
		mysql_query($update);
	}
	
	
	
	unset($user, $item, $artist);
	unset($status);

}		
echo mysql_error();
?>
