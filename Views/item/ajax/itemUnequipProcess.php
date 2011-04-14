<?php


$data['response'] = $response;
$data['error'] = $error;

$data['max_ram'] = $max_ram;
$data['max_hp'] = $max_hp;
$data['ram'] = $ram;
$data['hp'] = $hp;


echo json_encode($data);

?>