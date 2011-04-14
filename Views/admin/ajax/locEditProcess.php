<?php
if (!$success) {
	$data['loc_id'] = '';
	$data['name'] = 'baba';
}
echo json_encode($data);

?>