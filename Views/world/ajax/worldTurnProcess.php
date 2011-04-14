<?php

$data['bearing'] = $bearing;
$data['nextLoc'] = $nextLoc;
$data['junk'] = $junk;

$data['loc_id'] = $loc_id;

$data['deadEnd'] = $deadEnd;

//$data['artifacts'] = $artifacts['has_artifacts']?inc::module('artifacts',$artifacts):'';

$data['reloadBag'] = $reloadBag;

 if ($store['is_store']) {
	$data['store'] = inc::module('storefront',$store);
 }
 else {
	$data['store'] = '';
 }


$data['quest']['html'] = $quest['has_quest']?inc::quest($quest['path']):'';
if ($quest['tutorial_image']) {
	$data['quest']['tutorial_image'] = true;
}
echo json_encode($data);

?>