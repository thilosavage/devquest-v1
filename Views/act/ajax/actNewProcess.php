<?php
$data['history'] = historys::display(array($historys));
$data['action'] = inc::module('newBand',$bandData);

echo json_encode($data);
?>