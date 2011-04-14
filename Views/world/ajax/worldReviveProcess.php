<?php

$data = $directions;

$data['loc'] = $loc;
$data['name'] = $name;
$data['desc'] = $desc;
$data['energy'] = $energy;


//$data['hp'] = $hp;
$data['hp_bar_width'] = $_SESSION['user']['hp'] * (608/$_SESSION['user']['max_hp']);

$data['money'] = $money;
$data['quest'] = $quest['has_quest']?inc::quest($quest['path']):'';



$data['message'] = $rent?'You woke up on your couch ready to the start the day. And the landlord came and took $'.$rent.' rent':'You woke up ready to start the day.';
		
echo json_encode($data);

?>