<?php

$data['error'] = $error;

$data['value'] = $value;
$data['money'] = $money;

$data['max_ram'] = $max_ram;
$data['max_hp'] = $max_hp;

$data['cumulative'] = $cumulative;

echo json_encode($data);

?>