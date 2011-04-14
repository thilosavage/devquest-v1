<?php
$data['history'] = historys::display(array($historys));
$data['action'] = inc::module('show',$showData);

echo json_encode($data);
?>