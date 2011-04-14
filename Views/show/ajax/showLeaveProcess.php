<?php
$data['show'] = 'you left the show';
$data['history'] = historys::display(array($historys));
echo json_encode($data);
?>