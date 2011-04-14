<?php


$data['response'] = $response;
$data['error'] = $error;

$data['max_ram'] = $max_ram;
$data['max_hp'] = $max_hp;

echo json_encode($data);

?>