<?php



echo "<div id='bot-talk-content' style='border: 1px solid black; background-color: yellow; padding: 0px; margin-top: 20px; height: 338px;'>";

echo "<span style='position: absolute; top: 45px; left: 45px;'><img src='https://graph.facebook.com/".$data['bot']['fbid']."/picture?type=small'></span>";

echo "<h5 style='position: absolute; top: 14px; left: 109px;'>".$data['bot']['message']."</h5>";

//echo "<div id='control' style='width: 600px; position: absolute; top: 117px; left: 54px; height: 20px; background-color: black; z-index: 5;'>";

//echo "<span id='controlred' style='position: absolute; width: 110px; height: 20px; background-color: red;'></span>";

echo "</div>";



echo "<div id='bugs' style='position: absolute; top: 94px; left: 40px; width: 507px; height: 261px; background: url(".site::url."_images/hud/battle-bug-bg.jpg); z-index: 4;'>";
$left = 40;
$top = 20;

$bugCount = 1;
foreach ($data['bugs'] as $sKey => $bug){

	echo "<div id='fight-target' bug_id='".$sKey."' name='".$bug['bugname']."' class='fakelink fightMethodUse' style='position: absolute; top: ".$top."px; left: ".$left."px; width: 100px; height: 100px; z-index: 2; background: url(".site::url."_images/bugs/".$bug['bug_id'].".jpg);'>";
		
		echo "<span class='bugname'> Lvl ".$bug['level'];
		
		echo "<div>";
		echo "<span bug_id='".$sKey."' class='bug_max_hp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 100px; background-color: black;'></span>";
		echo "<span bug_id='".$sKey."' class='bug_hp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 100px; background-color: red;'></span>";
		echo "</div>";

	echo "</div>";
	
	$left = $left + 110;
	
	if ($bugCount == 4) {
		$left = 40;
		$top = 150;
	}
	$bugCount++;
	
}
echo "</div>";

//echo "<div id='laptop' style='position: absolute; top: 194px; left: 569px; width: 150px; height: 120px; z-index: 2; background: url(".site::url."_images/items/laptop1.png);'>";

//echo "<span style='position: absolute; top: 90px; left: 45px; background: black;'>";


//echo "</div>";		

echo "<span id='leave-fight' style='position: absolute; left: 584px; top: 333px; width: 126px;' class='fakelink fightCloseProcess'>Walk away</span>";



?>