<?php
//$data['response'] = $response;
//$data['gig'] = $gig;

if ($nextGig) {

	$gig = inc::module('gig',$nextGig);

}

$data['thanks'] = $response;
$data['response'] = $gig;

echo json_encode($data);
?>