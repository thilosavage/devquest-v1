<?php

if ($responseType == 'fight') {
	$fightData['bugs'] = $bugs;
	$fightData['bot'] = $bot;
	$fightData['hp_left'] = $hp_left;
	$fightData['max_hp'] = $max_hp;
	$response = inc::module('fight',$fightData);
	
}
else if ($responseType == 'sell') {

	$sellData['sells'] = $sells;
	$sellData['bot'] = $bot;
	$response = inc::module('sell',$sellData);

}
else {
	$nothingData['bot'] = $bot;
	$response = inc::module('nothing',$nothingData);
}

$data['responseType'] = $responseType;
$data['response'] = $response;
$data['bugs'] = $bugs;

$data['quest']['html'] = $quest['has_quest']?inc::quest($quest['path']):'';

echo json_encode($data);
?>