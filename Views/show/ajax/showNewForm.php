<?php
echo "<div class='action-header'>Creating New Show</div>";

$data['duration-vals'] = array_keys($durations);
$data['duration-vars'] = array_values($durations);
echo "<div class='show-form'>";
echo inc::form('show',$data);
echo "</div>";
?>