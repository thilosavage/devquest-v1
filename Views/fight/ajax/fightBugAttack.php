<?php

if ($dead){
	$results = "<span style='float: left; padding: 10px;'><img src='https://graph.facebook.com/".$bot['fbid']."/picture?type=large'></span>";
	$results .= "<strong>Your hp has died</strong>";
	$results .= "<hr>";
	$results .= "\"".$bot['name']." says ".$bot['fail']."\"";
	$results .= "<hr>";
	$results .= "<div style='padding: 10px;'>Level down, etc..<br>skills lost<br>- 1etc</div>";	
	
}
else {
	$results = '';
}
 
$data['hp'] = $hp;
$data['hp_left'] = $hp_left;
$data['damage'] = $damage;
$data['rPos'] = rand(0,90);
$data['dead'] = $dead;
$data['results'] = $results;

if ($dead) {
	$data['hp_bar_width'] = 0;
}
else {
	$data['hp_bar_width'] = $_SESSION['user']['hp'] * (100/$_SESSION['user']['max_hp']);
}

echo json_encode($data);
?>