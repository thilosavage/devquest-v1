<?php

$data['updates'] = $updates;
$data['type'] = $type;
$data['cumulative'] = $cumulative;

$data['hp_bar_width'] = $_SESSION['user']['hp'] * (138/$_SESSION['user']['max_hp']);

echo json_encode($data);

?>