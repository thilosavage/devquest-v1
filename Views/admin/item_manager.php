<?php
echo form::start(site::url.'admin/item_manager');
echo "<table>";

$vix = array(
	'item_id',
	'name',
	'desc',
	'value',
	'level',
	'cumulative',
	'in_store',
	'in_bot',
	'speed',
	'charisma',
	'focus',
	'hacking',
	'wisdom',
	'max_hp',
	'max_ram',
	'hp',
	'ram',
	'type'
	);

echo "<tr><td></td>";
foreach ($vix as $vi) {
	echo "<td><span style='font-size: 9px;'>".substr($vi,0,12)."</span></td>";
}

echo "</tr>";

$items[] = array(
	'item_id'=>'new'
	);

foreach ($items as $item) {

	echo "<tr>";
	
	echo "<td>".form::hidden($item['item_id'].'[item_id]',$item['item_id']).$item['item_id']."</td>";
	
	foreach ($vix as $vi) {
	
		if ($vi == 'name' || $vi == 'desc' || $vi == 'type') {
			$length = 160;
		}
		else {
			$length = 25;
		}	
	
		echo "<td>".form::input($item['item_id'].'['.$vi.']',$item[$vi],' style="width:'.$length.'px;"')."</td>";
	}
	
	echo "</tr>";
	
}
echo "</table>";
echo form::submit('change','change');
echo form::end();
?>