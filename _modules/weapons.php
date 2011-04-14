<?php
$skills = $data['skills'];
$softwares = $data['softwares'];

echo "<table cellpadding='1' cellspacing='1'>";

	echo "<tr>";
	
	foreach ($skills as $skill) {
		echo "<td><div class='finger skill-unselected fightMethodSelect' cd='".$skill['cooldown']."' skill_id='".$skill['skill_id']."' desc='".$skill['desc']."' name='".$skill['name']."'>";
		echo "<img src='".site::url."_images/skills/".$skill['skill_id'].".png'>";
		echo "</div></td>";
	}
	$skillExtras = 10 - count($skills);
	$i = 0;
	while ($i < $skillExtras) {
		echo "<td><div style='width: 70px; height: 70px;' class='skill-unselected' desc=''>-</div></td>";	
		$i++;
	}
	echo "</tr><tr>";
	
	foreach ($softwares as $software){
		echo "<td><div class='finger software-unselected fightMethodSelect' cd='".$software['cooldown']."' ram='".$software['ram']."' software_id='".$software['software_id']."' desc='".$software['desc']."' name='".$software['name']."''>";
		
		echo "<img src='".site::url."_images/software/".$software['software_id'].".png'>";
		echo "</div></td>";
		
		
	}
	$softwareExtras = 10 - count($softwares);
	$i = 0;
	while ($i < $softwareExtras) {
		echo "<td><div style='width: 70px; height: 70px;' class='skill-unselected' desc=''>-</div></td>";	
		$i++;
	}	
	echo "</tr>";
	
echo "</table>";

echo "<div id='fight-tool-tip' style='color: white; background-color: black; position: absolute; top: 137px; font-size: 11px; margin-left: 10px;'></div>";
?>