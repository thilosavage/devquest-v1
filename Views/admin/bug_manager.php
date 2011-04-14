<?php
echo form::start(site::url.'admin/bug_manager');
echo "<table>";

$vix = array(
	'bugtype_id',
	'bugname',
	'level',
	'hp',
	'damage',
	'defense',
	'cooldown'
	);

echo "<tr><td></td>";
foreach ($vix as $vi) {
	echo "<td>".$vi."</td>";
}

echo "</tr>";

$bugs[] = array(
	'bugtype_id'=>'1',
	'bug_id'=>'new'
	);

foreach ($bugs as $bug) {

	echo "<tr>";
	
	echo "<td>".form::hidden($bug['bug_id'].'[bug_id]',$bug['bug_id']).$bug['bug_id']."</td>";
	
	foreach ($vix as $vi) {
		echo "<td>".form::input($bug['bug_id'].'['.$vi.']',$bug[$vi])."</td>";	
	}
	
	echo "</tr>";
	
}
echo "</table>";
echo form::submit('change','change');
echo form::end();
?>