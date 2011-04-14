<?php
$data = $directions;

$data['store_id'] = $store['store_id'];

$data['newLoc'] = $newLoc;
$data['nextLoc'] = $nextLoc;
$data['rightLoc'] = $rightLoc;
$data['leftLoc'] = $leftLoc;

$data['deadEnd'] = $deadEnd;

$data['desc'] = $desc;
$data['name'] = $name;

$data['direction'] = $direction;

// hud
$data['exp'] = $exp;
$data['money'] = $money;
$data['energy'] = $energy;

$data['gig'] = $gig['is_gig']?inc::module('gig',$gig['data']):'';

$data['job'] = $job['is_job']?inc::module($job['employed']?'work':'job',$job):'';

$data['store'] = $store['is_store']?inc::module('storefront',$store):'';
 
$data['reloadBag'] = $reloadBag;
 
$data['quest']['html'] = $quest['has_quest']?inc::quest($quest['path']):'';
$data['quest']['tutorial_image'] = $quest['tutorial_image'];

$data['bots'] = $bots['has_bots']?inc::module('bots',$bots):'';

$data['artifacts'] = $artifacts['has_artifacts']?inc::module('artifacts',$artifacts):'';

$data['message'] = $messageExists?$messageExists:'';

echo json_encode($data);
?>