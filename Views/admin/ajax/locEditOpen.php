<?php

echo "<div style='background-color: white;'>";

echo form::start(site::url.'admin/map');

if ($_POST['loc_id']){
	echo form::hidden('loc[loc_id]',$_POST['loc_id']);
}
else {
	echo form::hidden('loc[x]',$_POST['x']);
	echo form::hidden('loc[y]',$_POST['y']);
}

echo "name".form::input('loc[name]',$loc['name'])."<Br>";
echo "desc".form::text('loc[desc]',$loc['desc'])."<Br>";
echo "level".form::input('loc[level]',$loc['level'])."<Br>";
echo "bots".form::input('loc[has_bots]',$loc['has_bots'],' style="width: 25px;"')."<Br>";
echo "artifacts".form::input('loc[has_artifacts]',$loc['has_artifacts'],' style="width: 25px;"')."<Br>";
echo "gig".form::input('loc[has_gig]',$loc['has_gig'],' style="width: 25px;"');
echo "job".form::input('loc[has_job]',$loc['has_job'],' style="width: 25px;"')."<Br>";
echo "quest".form::input('loc[quest]',$loc['quest'])."<Br>";



echo form::submit('process','process');
echo form::submit('cancel','cancel','locEditCancel');

echo "</form>";

echo "</div>";
//echo $_POST['loc_id'];
//echo $_POST['x'];
//echo $_POST['y'];

		
?>