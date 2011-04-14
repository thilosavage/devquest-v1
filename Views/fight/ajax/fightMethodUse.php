<?php


if ($clear){
	//$results = "<div class='finger fightVictoryClose' style='border: 1px solid black; background-color: green; padding: 0px; margin-top: 20px; width: 540px; height: 318px;'>";
	//$results .= "<span style='float: left; padding: 10px;'><img src='https://graph.facebook.com/".$bot['fbid']."/picture?type=large'></span>";
	

	$results .= "<div style='color: white; font-size: 13px; padding-left: 13px; padding-right: 13px;'>";
	$results .= "<strong>Hard drive clear</strong>";

	$results .= "<hr>";
	$results .= "".$bot['name']." says <em>\"".$bot['thanks']."\"</em>";
	$results .= "<hr>";
	
	//$results .= "<div style='position: absolute; left: 239px; padding: 10px; width: 331px; font-size: 13px;'>";
	
	$results .= "You gained ".$expUp." experience<br>";	
	
	if ($levelUp) {
		$results .= "You are now level ".$level."<br>";
	}
	
	if ($skillsUp) {
		foreach ($skillsUp as $skillUp){
			$results .= "You are now ".$skillUp['ability']." at ".$skillUp['skill']."<br>";
		}
	}

	$results .= "</div>";
	
	//$results .= "<span id='leave-fight' class='fakelink' style='font-size: 22px;'>Click to close</span>";	

	//if ($artifacts) {
	//	$loot = "<span class='worldLootPickup fakelink' key='".$artifacts."'>Collect Items</span>";
	//}
	
	$loot = $artifacts;
	
	
	if ($cash) {
		$cash = "<span class='worldMoneyPickup fakelink' key='".$cash['key']."'><img src='".site::url."_images/money/money-".$cash['size'].".png'></span>";
	}

}

// hud
$data['exp'] = $exp;
$data['ram'] = $ram;

$data['ram_bar_width'] = $_SESSION['user']['ram'] * (608/$_SESSION['user']['max_ram']);


$data['energy'] = $energy;
$data['level'] = $level;


$data['bugs'] = $bugs;
$data['response'] = $response;
$data['clear'] = $clear;
$data['results'] = $results;
$data['loot'] = $loot;
$data['cash'] = $cash;

$data['bot']= $bot;

//$data['artifacts']= $artifacts;

$data['damage']= $damage;

$data['cooldown'] = $cooldown;

$data['quest']['html'] = $quest['has_quest']?inc::quest($quest['path']):'';

echo json_encode($data);

?>